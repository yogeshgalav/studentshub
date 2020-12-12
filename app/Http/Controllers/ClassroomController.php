<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Unit;
use DB;
use Auth;
use Illuminate\Support\Facades\Log;

class ClassroomController extends Controller
{
    //
    public function classroomListPage(){
        $classroom_query = DB::table('classrooms as cs')
        ->join('courses as co','co.id','=','cs.course_id')
        ->join('subjects as su','su.id','=','cs.subject_id')
        ->join('teachers as th','th.id','=','cs.teacher_id')
        ->join('users as us','us.id','=','th.user_id')
        ->select('cs.id','cs.name','co.course_name','su.subject_name','su.alias as subject_alias','us.id as user_id','us.full_name as teacher_name');

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
    public function getClassroomDetails($classroom_id){
        $classroomDetail = DB::table('classrooms as cs')
        ->where('cs.id',$classroom_id)
        ->join('courses as co','co.id','=','cs.course_id')
        ->join('subjects as su','su.id','=','cs.subject_id')
        ->join('teachers as th','th.id','=','cs.teacher_id')
        ->join('users as us','us.id','=','th.user_id')
        ->select('cs.*','co.course_name','su.subject_name','us.id as user_id','us.full_name as teacher_name')
        ->first();

        return response()->json([
            'success'=>[
                'classroomDetail'=>$classroomDetail
            ]
        ]);
    }

    public function update($classroomId,Request $request){
        $classroom=Classroom::findOrFail($classroomId);
        $classroom->update([
            'name'=> $request->name,
            'expected_students'=> $request->expected_students,
            'classroom_duration'=> $request->duration,
        ]);

        return response(['success'=>[
            'classroom'=>$classroom
        ]]);
    }

    public function classroomPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        if(Auth::teacher() && $classroom->teacher_id===Auth::teacher()->id){
            return view('classroom.classroom');
        }

        // $is_classroom_student=ClassroomUser::where('user_id',Auth::id())
        // ->where('classroom_id',$classroom->id)->where('joined_at','!=',null)->exists();
        return view('student-panel.my-panel');
    }

    public function classroomOverviewPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        return view('classroom.classroom-overview');
    }
    public function classroomSetupPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        return view('classroom.classroom-setup');
    }
    public function classroomUnitAssignmentPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);
                
        if(Auth::teacher() && $classroom->teacher_id===Auth::teacher()->id){
            return view('classroom.classroom-unit-assignment');
        }

        return view('student-panel.classroom-unit-assignment');
    }
    public function classroomDailyAssignmentPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);
        
        if(Auth::teacher() && $classroom->teacher_id===Auth::teacher()->id){
            return view('classroom.classroom-daily-assignment');
        }

        // $is_classroom_student=ClassroomUser::where('user_id',Auth::id())
        // ->where('classroom_id',$classroom->id)->where('joined_at','!=',null)->exists();
        return view('student-panel.classroom-daily-assignment');
    }
    public function classroomDailyReportPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);
        
        if(Auth::teacher() && $classroom->teacher_id===Auth::teacher()->id){
            return view('classroom.classroom-daily-report');
        }

        // $is_classroom_student=ClassroomUser::where('user_id',Auth::id())
        // ->where('classroom_id',$classroom->id)->where('joined_at','!=',null)->exists();
        return view('student-panel.classroom-daily-report');
    }
    public function classroomStudentPage($classroomId){
        $classroom = Classroom::findOrFail($classroomId);
        return view('classroom.classroom-student-details')->with(['classroom'=>$classroom] );
    }

    public function unitAttemptPage(){
        return view('student-panel.unit-attempt');
    }

    public function studentPanelPage($classroom_id,$user_id=null){
        if($user_id){
            return view('classroom.student-panel');
        }

        return view('student-panel.my-panel');
    }

    public function createClassroomPage(Request $request){
        $course_levels = \App\Models\CourseLevel::get();
        return view('classroom.create-classroom')
        ->with('course_levels',$course_levels);
    }
    public function createClassroom(Request $request){
        $subject_id = $request->subject['id'];
        $subject_name = $request->subject['subject_name'];
        $course_id = $request->course['id'];
        $course_name = $request->course['course_name'];

        if(Classroom::where('classroom_live_id',$request->classroom_id)->exists()){
            return response()->json(['error'=>[
                'field'=>'classroom_id',
                'message'=>'This Classroom Id is already used. Please try another.'
            ]],422);
        }
        DB::beginTransaction();
    try{
        if($course_id){
            $course = \App\Models\Course::findOrFail($course_id);
        }else{
            $course=\App\Models\Course::create([
                'course_url'=>\Str::slug($course_name),
                'course_name'=>$course_name,
                'category_id'=>null
            ]);
        }

        if($subject_id){
            $subject = \App\Models\Subject::findOrFail($subject_id);
        }else{
            $subject= \App\Models\Subject::create([
                'subject_url'=>\Str::slug($subject_name),
                'subject_name'=>$subject_name,
                'category_id'=>$course->category_id ?? null
            ]);
        }

        $classroom=new Classroom;
        $classroom->name=$request->name;
        $classroom->teacher_id=Auth::teacher()->id;
        $classroom->subject_id=$subject->id;
        $classroom->course_id=$course->id;
        $classroom->batch_start_year=$request->start_year;
        $classroom->batch_end_year=$request->end_year;
        $classroom->save();

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('classroom create failure: with data ',$request->all());
        return response()->$e;
    }
        return response()->json(['success'=>[
            'id'=>$classroom->id,
            'live_id'=>$classroom->classroom_live_id
        ]]);
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
