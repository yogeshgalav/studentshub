<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassroomResource;
use App\Models\Resource;
use App\Models\Video;
use App\Models\Unit;
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

        $classroom_resource = new ClassroomResource;
        $classroom_resource->classroom_id = $classroomId;
        $classroom_resource->type = $request->resource_type;
        $classroom_resource->link = $request->resource_link;
        $classroom_resource->unit_id = $request->unit_id;
        $classroom_resource->description = $request->description;
        $classroom_resource->save();

        //create post
        // if('documentLink'===$request->resource_type){
        //     $document = new Document;
        //     $document->ext = 'pdf';
        //     $document->link = $request->resource_link;
        //     $document->save();
        // }
        
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
