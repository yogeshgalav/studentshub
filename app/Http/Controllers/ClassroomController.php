<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Unit;
use App\Models\ClassroomUser;
use DB;
use Auth;
use Illuminate\Support\Facades\Log;

class ClassroomController extends Controller
{
    //
    public function classroomPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        if(Auth::user()->can('update', $classroom)){
            return view('classroom.classroom');
        }

        $daily_assignment=\App\Models\DailyAssignment::where('attempt_date','=',now(Auth::user()->timezone)->toDateString())
        ->where('activated_at','!=',null)->where('classroom_id','=',$classroom->id)
        ->with('dailyQuestions.multipleChoice')->first();

        // check if assignment is not already attempted
        $daily_report=null;
        if($daily_assignment){
            // $daily_assignment->dailyQuestions->makeHidden('correct_answer');
            $daily_report = \App\Models\DailyReport::where('user_id',Auth::id())
            ->where('daily_assignment_id',$daily_assignment->id)->first();
        }

        if($daily_assignment && $daily_assignment->isCurrentlyAvailable() && empty($daily_report)){
            return view('student-panel.daily-attempt')
            ->with('nocache',true)
            ->with('daily_assignment',$daily_assignment);
        }

        return view('student-panel.my-panel');
    }

    public function classroomOverviewPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        if(Auth::user()->can('update', $classroom)){
            return view('classroom.overview');
        }

        return view('student-panel.overview');
    }
    public function classroomSetupPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        return view('classroom.classroom-setup');
    }

    public function classroomAttendancePage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        if(Auth::user()->can('update', $classroom)){
            return view('classroom.classroom-attendance-page');
        }

        return view('student-panel.classroom-attendance-page');
    }
    public function classroomUnitAssignmentPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        if(Auth::user()->can('update', $classroom)){
            return view('classroom.classroom-unit-assignment');
        }

        return view('student-panel.classroom-unit-assignment');
    }
    public function classroomDailyAssignmentPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        if($classroom->teacher_user_id===Auth::user()->id){
            return view('classroom.classroom-daily-assignment');
        }

        // $is_classroom_student=ClassroomUser::where('user_id',Auth::id())
        // ->where('classroom_id',$classroom->id)->where('joined_at','!=',null)->exists();
        return view('student-panel.classroom-daily-assignment');
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
        $institute_list = DB::table('institutes as in')
        ->join('institute_users as inu', function($join){
            $join->on('in.id','=','inu.institute_id')->where('inu.user_id','=',Auth::id());
        })
        ->select('in.id','in.name')
        ->groupBy('in.id')
        ->get();

        if(empty($institute_list)){
            abort(403);
        }

        return view('classroom.create-classroom')
        ->with('institute_list',$institute_list)
        ->with('course_levels',$course_levels);
    }
    public function classroomListPage(){
        // $classroom_list = DB::table('classrooms as cs')
        // //->join('batches as bt','bt.id','=','cs.batch_id')
        // ->join('courses as co','co.id','=','cs.course_id')
        // ->join('subjects as su','su.id','=','cs.subject_id')
        // ->join('users as us','us.id','=','cs.teacher_user_id')
        // ->select('cs.id','cs.name','co.course_name','su.subject_name','su.alias as subject_alias','us.id as user_id','us.full_name as teacher_name')
        // ->whereIn('cs.id',Auth::user()->getClassroomIds())
        // ->get();

        return view('classroom.classroom-list');
        // ->with([
        //     'classroomList'=>$classroom_list,
        // ]);
    }

    public function classroomResoucePage(){
        return view('classroom.resources');
    }
    public function classroomDoubtPage(){
        return view('classroom.doubts');
    }
    public function classroomMessagePage(){
        return view('classroom.messages');
    }

    public function doubtPage()
    {
        $categories = \App\Models\Category::all();
        return view('student.doubts')->with('categories',$categories);
    }

    public function myReports()
    {
        $classrooms = DB::table('classroom_users as cu')
        ->where('cu.user_id',Auth::id())
        ->leftJoin('classrooms as cl', 'cl.id', '=', 'cu.classroom_id')
        ->select('cl.id','cl.name')
        ->get();

        return view('student-panel.my-reports')->with('classrooms',$classrooms);
    }

    public function doubtAnswersPage(){
        return view('doubt.answer');
    }
    public function GlobalMessagePage(){
        $classrooms = \DB::table('classrooms')
        ->leftJoin('users as usr',function($join){
            $join->on('usr.id','=','classrooms.teacher_user_id')->where('usr.id','=',Auth::id());
        })
        ->leftJoin('classroom_users as cu',function($join){
            $join->on('cu.classroom_id','=','classrooms.id')->where('cu.user_id','=',Auth::id());
        })
        ->where('usr.id','!=',null)
        ->orWhere('cu.id','!=',null)
        ->select('classrooms.id','classrooms.name')
        ->get();

        return view('classroom.global-messages')
        ->with('classrooms',$classrooms);
    }
    public function classmates()
    {
        return view('classroom.classmates');
    }
}