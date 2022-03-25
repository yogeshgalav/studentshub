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
use App\Models\DailyQuestion;

class ReportController extends Controller
{
    public function getAnswerReport(DailyAssignment $daily_assignment, User $user){
        if(!$daily_report = DailyReport::where('daily_assignment_id',$daily_assignment->id)->where('user_id', $user->id)->first()){
            return response()->json(['success'=>[
                'daily_report'=>null,
                'daily_questions'=>[],
            ]]);    
        }

        $daily_questions = DailyQuestion::where('daily_assignment_id', $daily_assignment->id)
            ->with('multipleChoice')
            ->with('dailyAnswer', function($query)use($user){
                $query->where('daily_answers.user_id',$user->id);
            })->get();

        return response()->json(['success'=>[
            'daily_report'=>$daily_report,
            'daily_questions'=>$daily_questions,
        ]]);
    }
    public function getAssignmentReport($classroom_id, $user_id=null){
        $student_id = $user_id ? $user_id : Auth::id();
        $user_detail = $user_id ? User::findOrFail($user_id) : null;

        $today_report=null;
        $today_assignment=null;
        if(!$user_id){
            $today_assignment = DailyAssignment::where('attempt_date',Carbon::now(Auth::user()->timezone)->toDateString())
            ->where('activated_at','!=',null)
            ->where('classroom_id',$classroom_id)
            ->first();

            if($today_assignment){
                $today_report = DailyReport::where('user_id',Auth::id())
                ->where('daily_assignment_id',$today_assignment->id)->first();
            }
        }

        return response()->json(['success'=>[
            'user_detail'=>$user_detail,
            'today_assignment'=>$today_assignment,
            'today_report'=>$today_report,
            'is_available'=>$today_assignment ? $today_assignment->isCurrentlyAvailable() : false
        ]]);
    }

    public function getStudentReport($classroom_id,$user_id = null){
        $user_id = $user_id ? $user_id : Auth::id();

        $assignments_attempts = DB::table('daily_assignments as da')
        ->where('da.classroom_id',$classroom_id)
        ->rightJoin('units as un','da.unit_id','=','un.id')
        ->leftJoin('daily_reports as dr',function($join)use($user_id){
            $join->on('dr.daily_assignment_id','=','da.id')->where('dr.user_id',$user_id);
        })
        ->select('da.unit_id','un.unit_name as label',
        DB::raw('COUNT(distinct dr.id) as count'))
        ->groupBy('da.unit_id','un.unit_name')
        ->get();

        $average_scores = DB::table('daily_assignments as da')
        ->where('da.classroom_id',$classroom_id)
        ->leftJoin('daily_reports as dr2','dr2.daily_assignment_id','=','da.id')
        ->leftJoin('daily_reports as dr',function($join)use($user_id){
            $join->on('dr.daily_assignment_id','=','da.id')
            ->where('dr.user_id',$user_id);
        })
        ->select('da.attempt_date','dr.marks_obtained as student_score',
        DB::raw('AVG(dr2.marks_obtained) as classroom_score'))
        ->groupBy('da.attempt_date','dr.marks_obtained')
        ->get();    

        $score_data = DB::table('student_reports as sr')
        ->where('sr.user_id',$user_id)
        ->leftJoin('units',function($join)use($classroom_id){
            $join->on('units.id','=','sr.unit_id')
            ->where('units.classroom_id',$classroom_id);
        })
        ->select('sr.unit_id','score_type','score')
        ->groupBy('sr.unit_id','score_type','score')
        ->get();

        $summary_data = DB::table('daily_assignments as da')
        ->leftjoin('daily_reports as dr',function($join)use($user_id){
            $join->on('dr.daily_assignment_id','=','da.id')->where('dr.user_id',$user_id);
        })
        ->where('da.classroom_id',$classroom_id)
        ->select(
                DB::raw('FORMAT(AVG(dr.marks_obtained),1) as average_score'),
                DB::raw('FORMAT(AVG(dr.rank),0) as average_rank'),
                DB::raw('COUNT(distinct dr.id) as total_attempt'),
                DB::raw('COUNT(distinct da.id) as assisgment_count')
        )
        ->groupBy('da.classroom_id')
        ->first();

        return response()->json(['success'=>[
            'score_data'=>$score_data,
            'assignments_attempts' => $assignments_attempts,
            'average_scores' => $average_scores,
            'summary_data'=>$summary_data,
        ]]);
    }


    public function getClassroomReport($classroom_id){
        $student_details = DB::table('classroom_users as csu')
        ->where('csu.classroom_id',$classroom_id)
        ->join('users','users.id','=','csu.user_id')
        ->leftJoin('students as st','st.user_id','=','users.id')
        ->select('users.id as user_id','users.full_name as user_name','st.unique_college_id')
        ->get();

        $assignment_details = DB::table('daily_assignments as da')
        ->where('da.classroom_id',$classroom_id)
        ->rightJoin('daily_reports as dr','dr.daily_assignment_id','=','da.id')
        ->select('dr.*','da.attempt_date')
        ->orderBy('da.attempt_date')
        ->get();

        $pie_graph_data = DB::table('units as ut')
        ->where('ut.classroom_id',$classroom_id)
        ->leftjoin('daily_assignments as da','ut.classroom_id','=','da.classroom_id')
        ->select('ut.unit_name as label',DB::raw('COUNT(distinct da.id) as count'))
        ->groupBy('ut.id','ut.unit_name')
        ->get();
        
        $bar_data = DB::table('student_reports as sr')
        ->leftjoin('units','units.id','=','sr.unit_id')
        ->where('units.classroom_id',$classroom_id)
        ->select('sr.unit_id','sr.score_type',DB::raw('AVG(sr.score) as score'))
        ->groupBy('sr.unit_id','sr.score_type')
        ->get();

        $bar_line_data = DB::table('daily_assignments as da')
        ->where('da.classroom_id',$classroom_id)
        ->leftjoin('daily_reports as dr','dr.daily_assignment_id','=','da.id')
        ->select(DB::raw('MONTHNAME(da.attempt_date) as attempt_month'),DB::raw('AVG(dr.marks_obtained) as average_score'),
        DB::raw('FORMAT(COUNT(distinct dr.user_id)/COUNT(distinct da.id),0) as average_attempt'))
        ->groupBy(DB::raw('MONTHNAME(da.attempt_date)'))
        ->get();

        return response()->json(['success'=>[
            'student_details'=>$student_details,
            'assignment_details'=>$assignment_details,
            'pie_graph_data'=>$pie_graph_data,
            'bar_data'=>$bar_data,
            'bar_line_data'=>$bar_line_data
        ]]);
    }

    public function getQuestionsReports($classroomId,$assignmentId,Request $request){
        
        $daily_questions=DailyQuestion::where('daily_assignment_id',$assignmentId)
        ->with('multipleChoice')
        ->get();

        $questions_data = DB::table('daily_assignments as da')
        ->where('da.id',$assignmentId)
        ->rightjoin('daily_questions as dq','da.id','=','dq.daily_assignment_id')
        ->rightjoin('multiple_choices as mq','dq.id', '=','mq.daily_question_id')
        ->leftjoin('daily_answers as dans','mq.id','=','dans.selected_option_id')
        ->select('mq.option_order as label','dq.daily_assignment_id as daily_assignment_id',
        'dq.id as question_id',DB::raw('COUNT(distinct dans.id) as count'))
        ->groupBy('dq.daily_assignment_id','dq.id','mq.option_order')
        ->get();
        
        $summary_data = DB::table('daily_assignments as da')
        ->where('da.id',$assignmentId)
        ->leftjoin('daily_reports as dr','da.id','=','dr.daily_assignment_id')
        ->select('da.id as daily_assignment_id',DB::raw('COUNT(distinct dr.user_id) as total_attempt'),
                DB::raw('AVG(dr.marks_obtained) as average_score'),
                DB::raw('SEC_TO_TIME(AVG(TIME_TO_SEC(dr.duration))) as average_duration')
        )
        ->groupBy('da.id')
        ->first();

        $score_data = DB::table('daily_assignments as da')
        ->where('da.id',$assignmentId)
        ->leftjoin('daily_reports as dr','da.id','=','dr.daily_assignment_id')
        ->select('da.id as daily_assignment_id',DB::raw("SUM(CASE WHEN (dr.marks_obtained < 4) THEN 1 ELSE 0 END) as low_count"),
                DB::raw("SUM(CASE WHEN (dr.marks_obtained > 3 and dr.marks_obtained < 8) THEN 1 ELSE 0 END) as medium_count"),
                DB::raw("SUM(CASE WHEN (dr.marks_obtained > 7) THEN 1 ELSE 0 END) as high_count"))
        ->groupBy('da.id')
        ->first();
        return response()->json([
            'success'=>[
                'daily_questions'=>$daily_questions,
                'questions_data'=>$questions_data,
                'score_data'=>$score_data,
                'summary_data'=>$summary_data
            ]
        ]);
    }
}
