<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\DailyReport;
use App\Models\DailyAssignment;

class ReportController extends Controller
{
    public function getAssignmentReport($classroom_id, $user_id=null){
        $student_id = $user_id ? $user_id : Auth::id();
        $user_detail = $user_id ? User::findOrFail($user_id) : null;
        $daily_reports=DB::table('classrooms as cl')->where('cl.id',$classroom_id)
        ->rightJoin('daily_assignments as da','da.classroom_id','=','cl.id')
        ->rightJoin('daily_reports as dr',function($join)use($student_id){
            $join->on('dr.daily_assignment_id','=','da.id')->where('user_id','=',$student_id);
        })
        ->select('dr.*','da.attempt_date')
        ->orderBy('da.attempt_date','DESC')
        ->get();

        $current_report = null;
        if(count($daily_reports)){
            $current_report = DailyReport::where('id',$daily_reports[0]->id)
            ->with('DailyAnswer.dailyQuestion.multipleChoice')
            ->first();
        }

        $today_report=null;
        $today_assignment=null;
        if(!$user_id){
            $today_assignment = DailyAssignment::where('attempt_date',Carbon::now(Auth::user()->timezone)->toDateString())
            ->where('activated_at','!=',null)
            ->where('classroom_id',$classroom_id)
            ->with('dailyQuestions.multipleChoice')
            ->with('dailyQuestions.myDailyAnswer')
            ->first();

            if($today_assignment){
                $today_report = DailyReport::where('user_id',Auth::id())
                ->where('daily_assignment_id',$today_assignment->id)->first();
            }
        }

        return response()->json(['success'=>[
            'daily_reports'=>$daily_reports,
            'user_detail'=>$user_detail,
            'current_report'=>$current_report,
            'today_assignment'=>$today_assignment,
            'today_report'=>$today_report,
            'is_available'=>$today_assignment ? $today_assignment->isCurrentlyAvailable() : false
        ]]);
    }
    public function getStudentReport($classroom_id,$user_id){
        $user_id = $user_id ? $user_id : Auth::id();

        $assignments_attempts = DB::table('daily_assignments as da')
        ->where('da.classroom_id',$classroom_id)
        ->rightJoin('units as un','da.unit_id','=','un.id')
        ->leftJoin('daily_reports as dr',function($join)use($user_id){
            $join->on('dr.daily_assignment_id','=','da.id')->where('dr.user_id',$user_id);
        })
        ->select(DB::raw('COUNT(distinct dr.id) as count'),'da.unit_id','un.unit_name as label')
        ->groupBy('da.unit_id','un.unit_name')
        ->get();

        $average_scores = DB::table('daily_assignments as da')
        ->where('da.classroom_id',$classroom_id)
        ->leftJoin('daily_reports as dr2','dr2.daily_assignment_id','=','da.id')
        ->leftJoin('daily_reports as dr',function($join)use($user_id){
            $join->on('dr.daily_assignment_id','=','da.id')
            ->where('dr.user_id',$user_id);
        })
        ->select(DB::raw('AVG(dr2.marks_obtained) as classroom_score'),'da.attempt_date','dr.marks_obtained as student_score')
        ->groupBy('da.attempt_date','dr.marks_obtained')
        ->get();    

        $multi_bar = DB::table('student_reports as sr')
        ->where('sr.user_id',$user_id)
        ->leftJoin('units',function($join)use($classroom_id){
            $join->on('units.id','=','sr.unit_id')
            ->where('units.classroom_id',$classroom_id);
        })
        ->select('sr.unit_id','score_type','score')
        ->groupBy('sr.unit_id','score_type','score')
        ->get();

        return response()->json(['success'=>[
            'reports_summary'=>$multi_bar,
            'assignments_attempts' => $assignments_attempts,
            'average_scores' => $average_scores
        ]]);
    }
}
