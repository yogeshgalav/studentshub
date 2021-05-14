<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\DailyAssignment;
use App\Models\DailyQuestion;
use App\Models\DailyAnswer;
use App\Models\DailyReport;
use App\Models\User;
use Auth;
use DB;
use Log;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DailyReportController extends Controller
{
    //api end point for getting student's daily assignment report page
    public function getDailyReports($classroom_id, $user_id=null){
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

    public function getDailyAnswers(Request $request){
        $daily_assignment = DailyReport::where('id',$request->report_id)
        ->with('DailyAnswer.dailyQuestion.multipleChoice')
        ->first();

        return response()->json(['success'=>[
            'daily_assignment'=>$daily_assignment
        ]]);
    }
    public function declineAttempt($daily_assignment_id){

        $report = DailyReport::create([
            'user_id'=>Auth::id(),
            'daily_assignment_id'=>$daily_assignment_id,
            'duration'=>'00:00:00',
            'rank'=>0,
            'marks_obtained'=>0,
            'status'=>'declined'
        ]);

        return true;
    }
    public function studentReports($classroom_id,$user_id){

        $assignments_attemps = DB::table('daily_assignments as da')
        ->where('da.classroom_id',$classroom_id)
        ->leftjoin('daily_reports as dr','dr.daily_assignment_id','=','da.id')
        ->select(DB::raw('COUNT(distinct dr.id) as count'),'da.unit_id as label')
        ->groupBy('da.unit_id')
        ->get();

        $average_scores = DB::table('daily_assignments as da')
        ->where('da.classroom_id',$classroom_id)
        ->leftjoin('daily_reports as dr2','dr2.daily_assignment_id','=','da.id')
        ->leftjoin('daily_reports as dr',function($join)use($user_id){
            $join->on('dr.daily_assignment_id','=','da.id')
            ->where('dr.user_id',$user_id);
        })
        ->select(DB::raw('AVG(dr2.marks_obtained) as classroom_score'),'da.attempt_date','dr.marks_obtained as student_score')
        ->groupBy('da.attempt_date','dr.marks_obtained')
        ->get();    

        return response()->json(['success'=>[
            'assignments_attemps' => $assignments_attemps,
            'average_scores' => $average_scores
        ]]);
    }
}