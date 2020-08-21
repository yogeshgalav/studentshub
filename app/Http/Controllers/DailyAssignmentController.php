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

    public function updateDailyQuestion(StoreRequest $request)
    {    
        $dailyQuestion = DailyQuestion::firstOrNew([
            'daily_assignment_id' => $request->daily_assignment_id,
            'question_order' => $request->question_order,
            'question_text' => $request->question_text,
            'question_type' => $request->question_type
        ]);

        foreach($request->choices as $choice){
            $multiple_choice =MultipleChoice::firstOrNew([
                'daily_question_id' => $request->daily_question_id,
                'choice_order' => $request->choice_order,
                'choice_text' => $request->choice_text
            ]); 
            
            $multiple_choice->save();
        }

        $dailyQuestion->save();

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
