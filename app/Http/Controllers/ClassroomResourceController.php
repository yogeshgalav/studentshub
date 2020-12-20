<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassroomDocument;
use App\Models\Document;
use App\Models\ClassroomVideo;
use App\Models\Video;
use App\Models\Unit;
class ClassroomResourceController extends Controller
{
    //
    public function listDocument(Request $request,$classroomId){
        $documentUnitData = Unit::where('classroom_id',$classroomId)
        ->with('classroomDocuments.document')
        ->get();

        return response()->json(['success'=>[
            'documentUnitData'=>$documentUnitData
        ]]);
    }
    public function addDocument(Request $request,$classroomId){
        $document = new Document;
        $document->ext = 'pdf';
        $document->link = $request->document_link;
        $document->save();

        $classroom_document = new ClassroomDocument;
        $classroom_document->classroom_id = $classroomId;
        $classroom_document->document_id = $document->id;
        $classroom_document->unit_id = $request->unit_id;
        $classroom_document->description = $request->description;
        $classroom_document->save();
        
        return response()->json(['success'=>[
            'document_id'=>$classroom_document->id
        ]]);
    }
    public function deleteDocument(Request $request){
        $classroom_document = ClassroomDocument::findOrFail($request->document_id);
        $classroom_document->delete();

        return response()->json([],204);
    }
    public function listVideo(Request $request,$classroomId){
        $videos = ClassroomVideo::where('classroom_id',$classroomId)
        ->leftJoin('videos as vi','vi.id','=','classroom_videos.classroom_id')
        ->leftJoin('units as ui','ui.id','=','classroom_videos.unit_id')
        ->select('ui.id as unit_id','ui.name as unit_name','vi.id as video_id','vi.link','classroom_videos.description')
        ->get();
        return response()->json(['success'=>[
            'videos'=>$videos
        ]]);
    }
    public function addVideo(Request $request,$classroomId){
        $videos = new Video;
        $videos->link = $request->videos_link;
        $videos->save();

        $classroom_videos = new ClassroomVideo;
        $classroom_videos->classroom_id = $classroomId;
        $classroom_videos->videos_id = $videos->id;
        $classroom_videos->unit_id = $request->unit_id;
        $classroom_videos->description = $request->description;
        $classroom_videos->save();
        
        return response()->json(['success'=>[
            'videos_id'=>$classroom_videos->id
        ]]);
    }
    public function deleteVideo(Request $request){
        $classroom_videos = ClassroomVideo::findOrFail($request->videos_id);
        $classroom_videos->delete();

        return response()->json([],204);
    }
}
