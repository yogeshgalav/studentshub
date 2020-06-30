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
        $classroom_query = DB::table('classrooms as cs')
        ->join('courses as co','co.id','=','cs.course_id')
        ->join('subjects as su','su.id','=','cs.subject_id')
        ->join('teachers as th','th.id','=','cs.teacher_id')
        ->join('users as us','us.id','=','th.user_id')
        ->select('cs.name','co.course_name','su.subject_name','su.alias as subject_alias','us.id as user_id','us.full_name as teacher_name');
        
        $classroom_query2=clone $classroom_query;
        
        $classroom_list=$classroom_query->rightJoin('classroom_users as cu',function($join){
            $join->on('cu.classroom_id','=','cs.id')->where('cu.user_id',Auth::id())->where('joined_at','!=',null);
        })
        ->get();

        $teacher=Auth::user()->teacher;
        if($teacher){
            $my_classrooms=$classroom_query2->where('teacher_id','=',$teacher->id)->get();
        }else{
            $my_classrooms=[];
        }
        
        return view('classroom.classroom-list')
        ->with([
            'classroomList'=>$classroom_list,
            'myClassrooms'=>$my_classrooms,
            'teacher'=>$teacher ? true :false,
        ]);
    }

    public function classroomPage($classroomName){
        $classroom=Classroom::where('name','=',$classroomName)->firstOrFail();
        $classroomDetail=DB::table('classrooms as cs')
        ->where('cs.id',$classroom->id)
        ->join('courses as co','co.id','=','cs.course_id')
        ->join('subjects as su','su.id','=','cs.subject_id')
        ->join('teachers as th','th.id','=','cs.teacher_id')
        ->join('users as us','us.id','=','th.user_id')
        ->select('cs.name','co.course_name','su.subject_name','us.id as user_id','us.full_name as teacher_name')
        ->first();
       
        if($classroomDetail->user_id===Auth::id()){
            return view('classroom.classroom')->with('classroomDetail',$classroomDetail);    
        }
        // $is_classroom_student=ClassroomUser::where('user_id',Auth::id())
        // ->where('classroom_id',$classroom->id)->where('joined_at','!=',null)->exists();
        return view('student-panel.my-panel')->with('classroomDetail',$classroomDetail);
    }
    
    public function unitAttemptPage(){
        return view('student-panel.unit-attempt');
    }

    public function studentPanelPage(){
        return view('student-panel.my-panel');
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
