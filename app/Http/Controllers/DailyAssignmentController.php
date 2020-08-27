<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherDailyAssignment\StoreRequest;
use App\Models\DailyAssignment;
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
        $unit=Unit::findOrFail($request->unit_id);

        if($request->assignment_id){
            $dailyAssignment = DailyAssignment::find($request->assignment_id);     
        }else{
            $dailyAssignment = new DailyAssignment;
        }   
        $dailyAssignment->attempt_date=$request->attempt_date;
        $dailyAssignment->unit_id=$unit->id;
        $dailyAssignment->classroom_id=$unit->classroom_id;

        $dailyAssignment->save();

        return response()->json(['success'=>[
            'assignment'=>$dailyAssignment
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
        ->where('activated_at','!=',null)->where('classroom_id','=',$classroom_id)
        ->with('dailyQuestions.multipleChoice')->first();

        return view('student-panel.daily-attempt')
        ->with('daily_assignment',$daily_assignment);
    }
}
