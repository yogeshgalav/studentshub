<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Chatroom;
use App\Models\Unit;
use App\Models\ClassroomUser;
use DB;
use Auth;
use Illuminate\Support\Facades\Log;

class ClassroomController extends Controller
{
    public function create(Request $request){
        $user = Auth::user();
        $course_levels = \App\Models\CourseLevel::get();
        $institute_query = DB::table('institutes as in');
        if($user->role!=='sthubAdmin'){
            $institute_query = $institute_query->join('institute_users as inu', function($join){
                $join->on('in.id','=','inu.institute_id')->where('inu.user_id','=',Auth::id());
            });
        }
        $institute_list=$institute_query
        ->select('in.id','in.name')
        ->groupBy('in.id','in.name')
        ->get();

        if(empty($institute_list)){
            abort(403);
        }

        return inertia('classroom/teacher/create', [
            'institute_list'=>$institute_list,
            'course_levels'=>$course_levels
        ]);
    }

    public function index()
    {
        return inertia('classroom/classroom-list');
    }
    
    public function show($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        if(Auth::user()->can('update', $classroom)){
            return inertia('classroom/teacher/menu');
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
            return inertia('student/daily-attempt', [
                'dailyAssignment' => $daily_assignment
            ]);
        }

        return inertia('classroom/student/menu');
    }

    public function classroomOverviewPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        if(Auth::user()->can('update', $classroom)){
            return inertia('classroom/teacher/overview');
        }

        return inertia('classroom/student/overview');
    }
    public function classroomSetupPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        return inertia('classroom/teacher/unit-plan');
    }

    public function classroomAttendancePage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        if(Auth::user()->can('update', $classroom)){
            return inertia('classroom/teacher/attendance');
        }

        return inertia('classroom/student/attendance');
    }
    public function classroomDailyAssignmentPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);

        if(Auth::user()->can('update', $classroom)){
            return inertia('classroom/teacher/daily-assignment');
        }

        return inertia('classroom/student/daily-assignment');
    }
    public function classroomStudentPage($classroomId){
        $classroom = Classroom::findOrFail($classroomId);
        return inertia('classroom/teacher/student-panel',['classroom'=>$classroom]);
    }

    public function studentPanelPage($classroom_id,$user_id=null){
        if($user_id){
            return inertia('classroom/teacher/student-panel');
        }

        return inertia('classroom/student/my-report');
    }

    public function classroom()
    {
        if(Auth::user()->role==='student'){
            return inertia('classroom/student/menu');
        }
        
        return inertia('classroom/teacher/menu');
    }

    public function classroomResoucePage(){
        return inertia('classroom/resources');
    }
    public function classroomMessagePage(){
        return inertia('classroom/messages');
    }


    public function myReports()
    {
        $classrooms = DB::table('classroom_users as cu')
        ->where('cu.user_id',Auth::id())
        ->leftJoin('classrooms as cl', 'cl.id', '=', 'cu.classroom_id')
        ->select('cl.id','cl.name')
        ->get();

        return inertia('classroom/student/my-report',[
            'classrooms' => $classrooms
        ]);
    }

    public function GlobalMessagePage($chatroomId){
        $chatrooms = DB::table('chatrooms as ch')
        ->leftjoin('users as us','us.id','=','ch.created_by_user_id')
        ->select('ch.id','ch.chatroom_name','us.id as user_id')
        ->get();
        return inertia('classroom/messages',[
            'chatroomId' => $chatroomId,
            'chatrooms' =>$chatrooms
        ]);
    }
    public function classmates()
    {
        return inertia('classroom/student/classmates');
    }
    public function indexHomework()
    {
        return inertia('classroom/index-homework');
    }
    public function showHomework()
    {
        return inertia('classroom/show-homework');
    }
}