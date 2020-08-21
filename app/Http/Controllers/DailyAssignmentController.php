<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherDailyAssignment\StoreRequest;
use App\Models\DailyAssignment;
use App\Models\DailyQuestion;
use App\Models\Unit;
use Illuminate\Http\Request;

class DailyAssignmentController extends Controller
{
    //
    public function updateDailyAssignment($unitId,Request $request)
    {    
            
        $dailyAssignment = DailyAssignment::firstOrNew([
            'attempt_date' => $request->attempt_date,
            'unit_id' => $unitId,
        ]);

        $dailyAssignment->save();

            return response()->json(['success'=>[
                'assignment'=>$dailyAssignment
            ]]);
        
    }

    public function updateDailyQuestion(Request $request)
    {    
        $dailyQuestion = DailyQuestion::firstOrNew([
            'daily_assignment_id' => $request->assignment_id,
            'marks' => $request->marks,
            'question_order' => $request->question_order,
            'question_text' => $request->question_text,
            'question_type' => $request->question_type,
        ]);
        $dailyQuestion->save();

        foreach($request->multiple_choice as $key=>$choice){
            $multiple_choice =MultipleChoice::firstOrNew([
                'daily_question_id' => $dailyQuestion->id,
                'choice_order' => $key,
                'choice_text' => $request->text,
                'is_correct' => $request->answer
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
