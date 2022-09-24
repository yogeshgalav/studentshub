<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{

    public function create(Request $request){

        $classroom=new Classroom;
        $classroom->user_id=Auth::user()->id;
        $classroom->category_id=$request->category_id;
        $classroom->course_id=$request->course_id;
        $classroom->subject_id=$request->subject_id;
        $classroom->institute_id=$request->institute_id;
        $classroom->save();

        return response()->json(['success'=>[
            'message'=>'Classroom Successfully Created'
          ]]);

    }

    public function delete(Request $request){

        $classroom = $request->id;
        $classroom->delete();
        return response()->json(['success'=>[
            'message'=>'Classroom Successfully deleted'
          ]]);

    }

    public function edit(Request $request){

        $classroom = Classroom::find($request->id);
        $classroom->category_id=$request->category_id;
        $classroom->course_id=$request->course_id;
        $classroom->subject_id=$request->subject_id;
        $classroom->institute_id=$request->institute_id;
        $classroom->save();
        return response()->json(['success'=>[
            'message'=>'Classroom Successfully edited'
          ]]);

    }

}