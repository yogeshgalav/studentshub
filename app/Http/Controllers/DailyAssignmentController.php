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
    public function activateDailyAssignment(Request $request){
        $daily = DailyAssignment::findOrFail($request->daily_assignment_id);
        if($request->status==="activate"){
            $daily->activated_at = now()->toDateTimeString();
        }else{
            $daily->activated_at = null;
        }
        $daily->save();

        return response()->json('success');
    }

    public function deleteDailyAssignment(Request $request){
        $daily = DailyAssignment::findOrFail($request->daily_assignment_id);

        $daily->delete();

        return response()->json('success');
    }

    public function updateDailyAssignment(Request $request)
    {    
        if($request->assignment_id){
            $dailyAssignment = DailyAssignment::find($request->assignment_id);     
        }else{
            $dailyAssignment = new DailyAssignment;
        }   
        $dailyAssignment->attempt_date=$request->attempt_date;
        $dailyAssignment->unit_id=$request->unit_id;

        $dailyAssignment->save();

        return response()->json(['success'=>[
            'assignment'=>$dailyAssignment
        ]]);
        
    }

    public function updateDailyQuestion(Request $request)
    {    
        $question=$request->question;
        if($question['id']){
            $dailyQuestion = DailyQuestion::find($question['id']);    
        }else{
            $dailyQuestion = new DailyQuestion;
        }
        $dailyQuestion->daily_assignment_id = $question['daily_assignment_id']; 
        $dailyQuestion->marks = $question['marks']; 
        $dailyQuestion->question_order = $question['question_order']; 
        $dailyQuestion->question_text = $question['question_text']; 
        $dailyQuestion->question_type = $question['question_type']; 

        $dailyQuestion->save();

        foreach($question['multiple_choice'] as $key=>$choice){
            if($choice['id']){
                $multiple_choice = MultipleChoice::find($choice['id']);    
            }else{
                $multiple_choice = new MultipleChoice;
            }
            $multiple_choice->daily_question_id = $dailyQuestion->id;
            $multiple_choice->option_order = $key;
            $multiple_choice->option_text = $choice['option_text'];
            $multiple_choice->is_correct = $choice['is_correct']=='true'?1:0;
            
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

    public function dailyAssignmentAttemptPage($classroom_id){
        $daily_assignment=\App\Models\DailyAssignment::where('attempt_date','=',now()->toDateString())
        ->whereHas('unit',function($query)use($classroom_id){
            return $query->where('classroom_id','=',$classroom_id);
        })->with('dailyQuestions.multipleChoice')->first();

        return view('student-panel.daily-attempt')
        ->with('daily_assignment',$daily_assignment);
    }

    public function deleteDailyQuestion(Request $request){
        DailyQuestion::where('id',$request->question_id)->delete();
        return 'success';
    }
}
