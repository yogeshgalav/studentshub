<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use DB;
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
    DB::beginTransaction();
    try{
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
        $dailyQuestion->correct_answer = $question['correct_answer']; 

        $dailyQuestion->save();
        $daily_question=$dailyQuestion->toArray();
        foreach($request->removed_options as $key=>$optionId){
            $multiple_choice = MultipleChoice::find($optionId);
            $multiple_choice->delete();
        }
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

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        \Log::critical('daily question update failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
        return response()->$e;
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
