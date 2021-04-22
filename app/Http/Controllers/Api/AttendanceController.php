<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use Auth;
use DB;

class AttendanceController extends Controller
{
    //
    private $currentTime;

    public function __construct(){
        $this->currentTime = Carbon::now(request()->user('api')->timezone);
    }

    public function startMeeting($classroomId){
        Attendance::firstOrCreate([
            'meet_date'=>$this->currentTime->toDateString(),
            'classroom_id'=>$classroomId,
        ]);
        return response()->json([], 204);
    }
    public function joinMeeting($classroomId){
        $attendance = Attendance::firstOrCreate([
            'meet_date'=>$this->currentTime->toDateString(),
            'classroom_id'=>$classroomId,
        ]);
        StudentAttendance::firstOrCreate([
            'attendance_id'=>$attendance->id,
            'user_id'=>Auth::id(),
        ],[
            'joined_at'=>$this->currentTime->toTimeString(),
        ]);
        return response()->json([], 204);
    }
    public function startAttendance($classroomId){
        $attendance = Attendance::firstOrCreate([
            'meet_date'=>$this->currentTime->toDateString(),
            'classroom_id'=>$classroomId,
        ]);
        $attendance->update([
            'ended_at'=>$this->currentTime->add(11, 'min')->toDateTimeString(),
        ]);
        return response()->json([], 204);
    }

    public function markPresent($classroomId){
        $attendance = Attendance::where('meet_date',$this->currentTime->toDateString())
        ->where('classroom_id',$classroomId)
        ->first();

        $student_attend = StudentAttendance::where([
            'attendance_id'=>$attendance->id,
            'user_id'=>Auth::id(),
        ])->first();

        if(empty($student_attend)){
            StudentAttendance::create([
                'attendance_id'=>$attendance->id,
                'user_id'=>Auth::id(),
                'present_at'=> $this->currentTime->toDateTimeString(),
                'joined_at'=> $this->currentTime->toDateTimeString(),
            ]);
        }else{
            $student_attend->present_at= $this->currentTime->toDateTimeString();
            $student_attend->save();
        }

        return $this->getStudentAttendance($classroomId);
    }

    public function getAttendanceData($classroomId){
        $selected_date = $request->date ?? $this->currentTime->toDateString();
        $today = DB::table('classroom_users as cu')->where('cu.classroom_id',$classroomId)
        ->join('users as us','us.id','=','cu.user_id')
        ->join('students as st','st.user_id','=','us.id')
        ->rightJoin('student_attendance as sa','sa.user_id','=','us.id')
        ->rightJoin('attendance as at',function($join)use($selected_date){
            $join->on('at.id','=','sa.attendance_id')->where('meet_date', $selected_date);
        })
        ->select('at.meet_date', 'us.full_name', 'sa.joined_at', 'sa.present_at', 'st.unique_college_id as institute_id')
        ->get();

       return response()->json(['success'=>[
           'today_attendance'=> $today,
       ]]); 
    }

    public function getAttendanceDates($classroomId){
        $attend_dates = DB::table('attendance as at')->where('classroom_id', $classroomId)
        ->select('at.meet_date')
        ->get();
        
       return response()->json(['success'=>[
           'attend_dates'=> $attend_dates,
       ]]); 
    }
    public function getStudentAttendance($classroomId){
        $attend_rows = DB::table('attendance as at')->where('classroom_id', $classroomId)
        ->rightJoin('student_attendance as sa',function($join){
            $join->on('sa.attendance_id','=','at.id')->where('user_id', Auth::id());
        })
        ->select('at.meet_date', 'sa.joined_at', 'sa.present_at')
        ->get();

        $attendance =Attendance::where('meet_date',$this->currentTime->toDateString())
        ->where('classroom_id',$classroomId)
        ->leftJoin('student_attendance as sa',function($join){
            $join->on('sa.attendance_id','=','attendance.id')->where('user_id', Auth::id());
        })
        ->first(); 
       
        return response()->json(['success'=>[
           'attend_rows'=> $attend_rows,
           'attendance'=> $attendance,
       ]]); 
    }
}
