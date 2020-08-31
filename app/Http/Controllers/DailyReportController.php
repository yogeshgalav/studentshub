<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    //
    
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
        ->where('classroom_id',$classroomId)->first();
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

        $total_marks = 0;
        foreach($request->answers as $answer){
            DailyAnswer::create([
                'user_id'=>Auth::id(),
                'daily_question_id'=>$answer['question_id'],
                'selected_answer'=>$answer['answer'],
            ]);
            $question=$daily_questions->where('id',$answer['question_id'])->first();
            if($question->correct_answer===$answer['answer']){
                $total_marks++;
            }
        }

        DailyReport::create([
            'user_id'=>Auth::id(),
            'daily_assignment_id'=>$request->daily_assignment_id,
            'marks_obtained'=>$total_marks
        ]);

        return redirect('/classroom/'.$request->classroom_id.'/daily-assignment');
    }

}
