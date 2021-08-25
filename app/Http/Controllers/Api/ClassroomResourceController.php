<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\AddResourceRequest;
use App\Models\ClassroomResource;
use App\Models\Classroom;
use App\Models\Resource;
use App\Models\Document;
use App\Models\Post;
use App\Models\SthubPost;
use App\Models\Video;
use App\Models\Unit;
use App\Models\ScheduledJob;
use App\Notifications\ResourceAdded;
use Illuminate\Support\Facades\Log;
use Auth;
use DB;

class ClassroomResourceController extends Controller
{
    //
    public function listResource(Request $request,$classroomId){
        $unit_list = Unit::where('classroom_id',$classroomId)
        ->orderBy('unit_no', 'DESC')
        ->get();

        $current_unit = $request->unitId ?? (count($unit_list) ? $unit_list[0]->id : 0);
        
        $resources = ClassroomResource::where('classroom_id',$classroomId)
        ->where('unit_id', $current_unit)
        ->leftJoin('likes as uli',function($join){
            $join->on('classroom_resources.id','=','uli.likable_id')->where('uli.likable_type','=','App\Models\ClassroomResources')->where('uli.user_id','=',Auth::id());
        })
        ->select('classroom_resources.*', 'uli.like_status as user_like')
        ->orderBy('created_at', 'DESC')
        ->get();

        return response()->json(['success'=>[
            'unit_list'=>$unit_list,
            'current_unit'=>$current_unit,
            'resources'=>$resources,
        ]]);
    }
    public function addResource(AddResourceRequest $request,$classroomId){

    DB::beginTransaction();
    try{
        $unit = Unit::findOrFail($request->unit_id);
        $classroom = Classroom::findOrFail($classroomId);

        $classroom_resource = new ClassroomResource;
        $classroom_resource->classroom_id = $classroom->id;
        $classroom_resource->type = $request->resource_type;
        $classroom_resource->link = $request->resource_link;
        $classroom_resource->unit_id = $unit->id;
        $classroom_resource->description = $request->description;
        $classroom_resource->save();
        ScheduledJob::newClassroomResourceNotification($classroom);
        if(in_array($request->resource_type,['documentLink','youtubeVideo'])){
            // $request->share_as_post && 
            $post=new Post;
            $post->user_id=Auth::user()->id;
            $post->post_heading=$unit->unit_name;
            $post->subject_id=$classroom->subject_id;


            switch ($request->resource_type) {
                case 'documentLink':
                    $document = new Document;
                $document->ext = 'pdf';
                $document->link = $request->resource_link;
                $document->save();

                $post->primary_image_path='/images/document.png';
                $post->postable_type="App\Models\Document";
                $post->postable_id=$document->id;
                    break;
    
                case 'youtubeVideo':
                    $video_id = substr($request->resource_link,strlen('https://www.youtube.com/embed/'));
                $video = new Video;
                $video->video_id = $video_id;
                $video->save();

                $post->primary_image_path='https://img.youtube.com/vi/'.$video_id.'/0.jpg';
                $post->postable_type="App\Models\Video";
                $post->postable_id=$video->id;
                    break;    
            }

            $post->post_description = $request->description;
            $post->category_id=$classroom->course->category_id;
            $post->course_id=$classroom->course_id;
            $post->created_via='resource';
            $post->save();

            SthubPost::addAction('share',$post,Auth::user());
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('classroom resources Creation failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
        return response()->$e;
    }
        // \Notification::send($classroom->users,new ResourceAdded);
        return response()->json(['success'=>[
            'resource_id'=>$classroom_resource->id
        ]]);
    }

    public function edit(ClassroomResource $classroom_resource, Request $request){
        $unit = Unit::findOrFail($request->unit_id);

        $classroom_resource->type = $request->resource_type;
        $classroom_resource->link = $request->resource_link;
        $classroom_resource->unit_id = $unit->id;
        $classroom_resource->description = $request->description;
        $classroom_resource->save();

        $new_post = false;
        $post = Post::where('id', $classroom_resource->post_id)->first();
        if(!$post && in_array($request->resource_type, ['documentLink','youtubeVideo'])){
            $new_post = true;
            $post = new Post;
            $post->user_id=Auth::user()->id;
            $post->subject_id=$classroom_resource->classroom->subject_id;
        }

        if($post){
            // $request->share_as_post && 
            $post->post_heading=$unit->unit_name;

            $old_postable_type = $post->postable_type;
            $old_postable_id = $post->postable_id;

            switch ($request->resource_type) {
                case 'documentLink':
                    if($old_postable_type===Document::class){
                        $document = Document::find($old_postable_id);
                    }else{
                        $document = new Document;
                        $post->primary_image_path='/images/document.png';
                        $post->postable_type="App\Models\Document";
                    }
    
                    $document->ext = 'pdf';
                    $document->link = $request->resource_link;
                    $document->save();
    
                    $post->postable_id=$document->id;
                    break;
    
                case 'youtubeVideo':
                    $video_id = substr($request->resource_link,strlen('https://www.youtube.com/embed/'));
    
                    if($old_postable_type===Document::class){
                        $video = Video::find($old_postable_id);
                    }else{
                        $video = new Video;
                        $post->primary_image_path='https://img.youtube.com/vi/'.$video_id.'/0.jpg';
                        $post->postable_type="App\Models\Video";
                    }
    
                    $video->video_id = $video_id;
                    $video->save();
    
                    $post->postable_id=$video->id;
                    break;    
            }

            $post->post_description = $request->description;
            $post->created_via='resource';
            $post->save();
            if(true===$new_post){
                SthubPost::addAction('share',$post,Auth::user());
            }
                $classroom_resource->post_id = $post->id;
        }else{
            $classroom_resource->post_id = null;
        }
        $classroom_resource->save();

        return response()->json([], 204);
    }

    public function delete(ClassroomResource $classroom_resource){
        $classroom_resource->delete();

        return response()->json([],204);
    }
}
