<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\DailyAssignment;
use App\Models\DailyQuestion;
use App\Models\DailyAnswer;
use App\Models\MultipleChoice;
use App\Models\DailyReport;
use Illuminate\Support\Facades\Log;

class DailyQuestionController extends Controller
{
    //
    //api end point for getting daily assisment data for students and teachers
    
    public function updateDailyQuestion(Request $request)
    {    
        $question=$request->question;
        $correct_answer=null;
        foreach($question['multiple_choice'] as $key=>$choice){
            if($choice['is_correct']=='true'){
                $correct_answer=$key;
                break;
            }
        }
        if($correct_answer===null){
            abort(422);
        }

        if(!empty($question['id'])){
            $dailyQuestion = DailyQuestion::find($question['id']);    
        }else{
            $dailyQuestion = new DailyQuestion;
        }
        $dailyQuestion->daily_assignment_id = $question['daily_assignment_id']; 
        $dailyQuestion->marks = $question['marks']; 
        $dailyQuestion->question_order = $question['question_order']; 
        $dailyQuestion->question_text = $question['question_text']; 
        $dailyQuestion->question_type = $question['question_type']; 
        $dailyQuestion->correct_answer = $correct_answer; 

        $dailyQuestion->save();

        foreach($question['multiple_choice'] as $key=>$choice){
            if(!empty($choice['id'])){
                $multiple_choice = MultipleChoice::find($choice['id']);    
            }else{
                $multiple_choice = new MultipleChoice;
            }
            $multiple_choice->daily_question_id = $dailyQuestion->id;
            $multiple_choice->option_order = $key;
            $multiple_choice->option_text = $choice['option_text'];
            $multiple_choice->save();
        }

        return response()->json(['success'=>[
            'assignment'=>$dailyQuestion
        ]]);
        
    }

    
    public function deleteDailyQuestion(Request $request){
        DailyQuestion::where('id',$request->question_id)->delete();
        return 'success';
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
