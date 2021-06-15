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
use App\Notifications\ResourceAdded;
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

        if($request->share_as_post && in_array($request->resource_type,['documentLink','youtubeVideo'])){
            $post=new Post;
            $post->user_id=Auth::user()->id;
            $post->post_heading=$unit->unit_name;
            $post->subject_id=$classroom->subject_id;

            if('documentLink'===$request->resource_type){
                $document = new Document;
                $document->ext = 'pdf';
                $document->link = $request->resource_link;
                $document->save();

                $post->primary_image_path='/images/document.png';
                $post->postable_type="App\Models\Document";
                $post->postable_id=$document->id;
            }
            if('youtubeVideo'===$request->resource_type){
                $video_id = substr($request->resource_link,strlen('https://www.youtube.com/embed/'));
                $video = new Video;
                $video->video_id = $video_id;
                $video->save();

                $post->primary_image_path='https://img.youtube.com/vi/'.$video_id.'/0.jpg';
                $post->postable_type="App\Models\Video";
                $post->postable_id=$video->id;
            }

            $post->post_description = $request->description;
            $post->category_id=$classroom->course()->category_id;
            $post->save();

            SthubPost::create([
                'post_id'=>$post->id,
                'classroom_id'=>$classroom->id,
                'course_id'=>$classroom->course_id,
                'shared_by_user_id'=>Auth::id(),
            ]);
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
    public function deleteResource(Request $request){
        $classroom_resource = ClassroomResource::findOrFail($request->resource_id);
        $classroom_resource->delete();

        return response()->json([],204);
    }
}
