<?php

namespace App\Http\Controllers;
use App\Models\DailyAssignment;
use App\Models\DailyQuestion;
use App\Models\DailyAnswer;
use App\Models\DailyReport;
use Auth;
use DB;
use Log;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function dailyAssignmentAttemptPage($classroom_id){
        $daily_assignment=\App\Models\DailyAssignment::where('attempt_date','=',now()->toDateString())
        ->where('activated_at','!=',null)->where('classroom_id','=',$classroom_id)
        ->with('dailyQuestions.multipleChoice')->first();
        $daily_report=null;
        if($daily_assignment){            
            $daily_report = DailyReport::where('user_id',Auth::id())
            ->where('daily_assignment_id',$daily_assignment->id)->first();
        }

        if($daily_assignment && !empty($daily_report)){
            return redirect('/classroom/'.$classroom_id.'/daily-assignment');
        }

        return view('student-panel.daily-attempt')
        ->with('daily_assignment',$daily_assignment);
    }

    public function studentDailyReport($classroomId){
        $daily_assignment = DailyAssignment::where('attempt_date',now()->toDateString())
        ->where('activated_at','!=',null)
        ->where('classroom_id',$classroomId)
        ->with('dailyQuestions.multipleChoice')
        ->with('dailyQuestions.dailyAnswer')
        ->first();
        $daily_report=null;
        if($daily_assignment){            
            $daily_report = DailyReport::where('user_id',Auth::id())
            ->where('daily_assignment_id',$daily_assignment->id)->first();
        }

        return response()->json(['success'=>[
            'daily_report'=>$daily_report,
            'daily_assignment'=>$daily_assignment
        ]]);
    }

    public function saveDailyAnswer(Request $request){
        $daily_questions = DailyQuestion::where('daily_assignment_id',$request->daily_assignment_id)->get();
        $rank = DailyReport::where('daily_assignment_id',$request->daily_assignment_id)->count();
        
        DB::beginTransaction();
    try{
        $total_marks = 0;
        foreach($request->answers as $answer){
            DailyAnswer::create([
                'user_id'=>Auth::id(),
                'daily_question_id'=>$answer['question_id'],
                'selected_answer'=>$answer['answer'],
            ]);
            $question=$daily_questions->where('id',$answer['question_id'])->first();
            if($question->correct_answer==$answer['answer']){
                $total_marks=$total_marks+$question->marks;
            }
        }

        DailyReport::create([
            'user_id'=>Auth::id(),
            'daily_assignment_id'=>$request->daily_assignment_id,
            'duration'=>$request->time,
            'rank'=>$rank+1,
            'marks_obtained'=>$total_marks
        ]);

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        \Log::critical('daily report save failure: with data ',$request->all());
        return response()->$e;
    }
        return redirect('/classroom/'.$request->classroom_id.'/daily-assignment');
    }

}
