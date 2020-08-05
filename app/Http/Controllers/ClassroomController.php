<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Unit;
use App\Http\Requests\JoinClassroomRequest;
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
        
        $classroom_list=$classroom_query->join('classroom_users as cu',function($join){
            $join->on('cu.classroom_id','=','cs.id')->where('cu.user_id',Auth::id())->where('joined_at','!=',null);
        })
        ->get();

        $teacher=Auth::teacher();
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

    //web endpoit to classroomm vieew for teachers
    public function classroomPage($classroomName){
        $classroom=Classroom::where('name','=',$classroomName)->firstOrFail();
        $classroomDetail=DB::table('classrooms as cs')
        ->where('cs.id',$classroom->id)
        ->join('courses as co','co.id','=','cs.course_id')
        ->join('subjects as su','su.id','=','cs.subject_id')
        ->join('teachers as th','th.id','=','cs.teacher_id')
        ->join('users as us','us.id','=','th.user_id')
        ->select('cs.*','co.course_name','su.subject_name','us.id as user_id','us.full_name as teacher_name')
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

    //api end point for getting unit assisment data for students and teachers
    public function getUnitAssismentDetails(Request $request){
        $unitData=Unit::where('classroom_id',$request->classroomId)
        ->with('descriptiveQuestions')
        ->get();

        return response()->json([
            'success'=>[
                'unitData'=>$unitData
            ]
        ]);
    }   

    public function createClassroomPage(Request $request){
        return view('classroom.create-classroom');
    }
    public function createClassroom(Request $request){
        $subject=Subject::firstOrCreate([
            'subject_url'=>\Str::slug($subject_name),
          ],[
          'subject_name'=>$subject_name,
          'category_id'=>$data['category_id']
          ]);

        $classroom=new CLassroom;
        $classroom->teacher_id=Auth::teacher()->id;
        $classroom->subject_id=$subject->id;
        $classroom->course_id=$course->id;
        $classroom->save();

    }

    public function joinClassroom(JoinClassroomRequest $request){
        $classroom=Classroom::where('name',$request->name)->first();

        ClassroomUser::firstOrCreate([
            'user_id'=>Auth::id(),
            'classroom_id'=>$classroom->id
        ]);

        return response()->json('success');
    }

    public function getPreviousUnitAnswers($classroom_id){
        $answers = DB::table('classroom_answers as ca')
        ->join('descriptive_questions as cq','cq.id','=','ca.descriptive_question_id')
        ->join('units',function($join)use($classroom_id){
            $join->on('units.id','=','cq.unit_id')->where('classroom_id','=',$classroom_id)->whereNotNull('unit.deactivated');
        })
        ->select()
        ->get();

        return response()->json(['success'=>[
            'answers'=>$answers
        ]]);
    }

}
