<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\DailyAssignment;
use App\Models\DailyQuestion;
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
            $dailyQuestion->daily_assignment_id = $request->daily_assignment_id; 
            $dailyQuestion->question_type = $question['question_type']; 
        }
        $dailyQuestion->marks = $question['marks']; 
        $dailyQuestion->question_order = $question['question_order']; 
        $dailyQuestion->question_text = $question['question_text']; 
        $dailyQuestion->correct_answer = $correct_answer; 

        $dailyQuestion->save();
        $daily_question=$dailyQuestion->toArray();
        foreach($question['multiple_choice'] as $key=>$choice){
            if(!empty($choice['id'])){
                $multiple_choice = MultipleChoice::find($choice['id']);    
            }else{
                $multiple_choice = new MultipleChoice;
                $multiple_choice->daily_question_id = $dailyQuestion->id;
            }
            $multiple_choice->option_order = $key;
            $multiple_choice->option_text = $choice['option_text'];
            $multiple_choice->save();
            $daily_question['multiple_choice'][]=$multiple_choice->toArray();
        }

        return response()->json(['success'=>[
            'question'=>$daily_question
        ]]);
        
    }

    
    public function deleteDailyQuestion(Request $request){
        DailyQuestion::where('id',$request->question_id)->delete();
        return 'success';
    }

}
