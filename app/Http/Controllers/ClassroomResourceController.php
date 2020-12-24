<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassroomResource;
use App\Models\Classroom;
use App\Models\Resource;
use App\Models\Document;
use App\Models\Post;
use App\Models\SthubPost;
use App\Models\Video;
use App\Models\Unit;
use Auth;
use DB;

class ClassroomResourceController extends Controller
{
    //
    public function listResource(Request $request,$classroomId){
        $resourceUnitData = Unit::where('classroom_id',$classroomId)
        ->with('classroomResources')
        ->get();

        return response()->json(['success'=>[
            'resourceUnitData'=>$resourceUnitData
        ]]);
    }
    public function addResource(Request $request,$classroomId){

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

        //create post
        if(in_array($request->resource_type,['documentLink','youtubeVideo'])){
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
            $post->save();

            SthubPost::create([
                'post_id'=>$post->id,
                'classroom_id'=>$classroom->id,
                'institute_id'=>$classroom->teacher->institute_id,
                'course_id'=>$classroom->batch->course_id,
                'batch_id'=>$classroom->batch_id,
                'category_id'=>$classroom->subject->category_id ?? null,
                'shared_by'=>Auth::user()->id,
            ]);
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('Post Creation failure: for user id#'.Auth::user()->id.' with data '.implode(', ',Arr::flatten($data)));
        return response()->$e;
    }
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
