<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use DB;
use Auth;

class ClassroomController extends Controller
{
    //
    public function classroomListPage(){
        return view('classroom.classroom-list');
    }

    public function classroomPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);
        $classroomDetail=DB::table('classrooms as cs')
        ->where('cs.id',$classroom->id)
        ->join('courses as co','co.id','=','cs.course_id')
        ->join('subjects as su','su.id','=','cs.subject_id')
        ->join('teachers as th','th.id','=','cs.teacher_id')
        ->join('users as us','us.id','=','th.user_id')
        ->select('co.course_name','su.subject_name','us.id as user_id','us.full_name as teacher_name')
        ->first();

        if($classroomDetail->user_id===Auth::id()){
            return view('classroom.classroom')->with('classroomDetail',$classroomDetail);    
        }
        return view('classroom.my-panel')->with('classroomDetail',$classroomDetail);
    }
    
    public function studentPanelPage(){
        return view('classroom.student-panel');
    }

    public function topicAnswersPage(){
        return view('classroom.topic-answers');
    }

    public function getClassroomUnitDetails(Request $request){
        $classroom=Classroom::findOrFail($request->classroomId);
        $unitDetails=DB::table('classrooms as cs')
        ->where('cs.id',$classroom->id)
        ->letJoin('unit as un','un.classroom_id','=','cs.id')
        ->letJoin('topic as to','to.unit_id','=','un.id')
        ->select('to.name','un.name')
        ->get();

        return response()->json([
            'success'=>[
                'unitDetails'=>$unitDetails
            ]
        ]);
    }

    public function getTopicAnswers(){

    }

}
