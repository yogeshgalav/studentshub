<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherDailyAssignment\StoreRequest;
use App\Models\DailyAssignment;
use App\Models\DailyQuestion;
use App\Models\MultipleChoice;
use App\Models\Unit;
use Illuminate\Http\Request;

class DailyAssignmentController extends Controller
{
    //
    public function updateDailyAssignment(Request $request)
    {    
            
        $dailyAssignment = DailyAssignment::firstOrNew([
            'attempt_date' => $request->attempt_date,
            'unit_id' => $request->unit_id,
        ]);

        $dailyAssignment->save();

            return response()->json(['success'=>[
                'assignment'=>$dailyAssignment
            ]]);
        
    }

    public function updateDailyQuestion(Request $request)
    {    
        $question=$request->question;
        $dailyQuestion = DailyQuestion::firstOrNew([
            'daily_assignment_id' => $question['assignment_id'],
            'marks' => $question['marks'],
            'question_order' => $question['question_order'],
            'question_text' => $question['question_text'],
            'question_type' => $question['question_type'],
        ]);
        $dailyQuestion->save();

        foreach($question['multiple_choice'] as $key=>$choice){
            $multiple_choice =MultipleChoice::firstOrNew([
                'daily_question_id' => $dailyQuestion->id,
                'option_order' => $key,
                'option_text' => $choice['text'],
                'is_correct' => $choice['answer']=='true'?1:0
            ]); 
            
            $multiple_choice->save();
        }

            return response()->json(['success'=>[
                'assignment'=>$dailyQuestion
            ]]);
        
    }

    public function getDailyAssismentDetails(Request $request){
        $unitList=Unit::where('classroom_id',$request->classroomId)
        ->with('dailyAssignment.dailyQuestions.multipleChoice')
        ->get();

        return response()->json([
            'success'=>[
                'unitList'=>$unitList
            ]
        ]);
    }   

}
