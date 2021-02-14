<?php

namespace App\Http\Controllers;
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
    public function dailyAssignmentAttemptPage($classroom_id){
        $daily_assignment=\App\Models\DailyAssignment::where('attempt_date','=',now(Auth::user()->timezone)->toDateString())
        ->where('activated_at','!=',null)->where('classroom_id','=',$classroom_id)
        ->with('dailyQuestions.multipleChoice')->first();
        
        // check if assignment is not already attempted
        $daily_report=null;
        if($daily_assignment){      
            $daily_assignment->dailyQuestions->makeHidden('correct_answer');      
            $daily_report = DailyReport::where('user_id',Auth::id())
            ->where('daily_assignment_id',$daily_assignment->id)->first();
        }

        if($daily_assignment && $daily_assignment->isCurrentlyAvailable() && empty($daily_report)){
            return view('student-panel.daily-attempt')
            ->with('nocache',true)
            ->with('daily_assignment',$daily_assignment);
        }
        
        return redirect('/classroom/'.$classroom_id.'/daily-assignment');
    }

    public function saveDailyAnswer(Request $request){
        $my_report = DailyReport::where('user_id',Auth::id())->where('daily_assignment_id',$request->daily_assignment_id)->exists();
        if($my_report){
            return redirect('/classroom/'.$request->classroom_id.'/daily-assignment');
        }
        $daily_questions = DailyQuestion::where('daily_assignment_id',$request->daily_assignment_id)->get();
        $rank = DailyReport::where('daily_assignment_id',$request->daily_assignment_id)->count();
        
        DB::beginTransaction();
    try{
        $total_marks = 0;
        foreach($request->answers as $answer){
            $question=$daily_questions->where('id',$answer['question_id'])->first();
            if($question->correct_answer==$answer['answer']){
                $total_marks=$total_marks+$question->marks;
            }
        }

        $report = DailyReport::create([
            'user_id'=>Auth::id(),
            'daily_assignment_id'=>$request->daily_assignment_id,
            'duration'=>'00:'.$request->time,
            'rank'=>$rank+1,
            'marks_obtained'=>$total_marks
        ]);

        foreach($request->answers as $answer){
            DailyAnswer::create([
                'user_id'=>Auth::id(),
                'daily_question_id'=>$answer['question_id'],
                'daily_report_id'=>$report->id,
                'selected_answer'=>$answer['answer'],
            ]);
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        \Log::critical('daily report save failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
        return response()->$e;
    }
        return redirect('/classroom/'.$request->classroom_id.'/daily-assignment');
    }

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
}
