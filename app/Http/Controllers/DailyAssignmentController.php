<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherDailyAssignment\StoreRequest;
use App\Models\DailyAssignment;
use App\Models\DailyQuestion;
use App\Models\Unit;
use DB;
use Log;
use Illuminate\Http\Request;

class DailyAssignmentController extends Controller
{
    //
    public function activateDailyAssignment(Request $request){
        $daily = DailyAssignment::findOrFail($request->daily_assignment_id);
        $marks=DailyQuestion::where('daily_assignment_id',$daily->id)->pluck('marks')->toArray();
        if(array_sum($marks)!==10){
            abort(403);
        }
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

        DB::beginTransaction();
    try{
        if($request->assignment_id){
            $dailyAssignment = DailyAssignment::find($request->assignment_id);     
        }else if(DailyAssignment::where('attempt_date',$request->attempt_date)->exists()){
                abort(422);
        }else{
            $dailyAssignment = new DailyAssignment;
        }   
        $dailyAssignment->attempt_date=$request->attempt_date;
        $dailyAssignment->unit_id=$unit->id;
        $dailyAssignment->classroom_id=$unit->classroom_id;

        $dailyAssignment->save();

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('daily assignment update failure: with data ',$request->all());
        return response()->$e; 
    }
        return response()->json(['success'=>[
            'assignment'=>$dailyAssignment
        ]]);
        
    }

    public function getDailyAssismentDetails(Request $request){
        $unitList=Unit::where('classroom_id',$request->classroomId)->get();
        $dailyAssignmentData=DailyAssignment::where('classroom_id',$request->classroomId)
        ->doesntHave('dailyReport')
        ->with('dailyQuestions.multipleChoice')
        ->get();

        return response()->json([
            'success'=>[
                'unitList'=>$unitList,
                'dailyAssignmentData'=>$dailyAssignmentData
            ]
        ]);
    }   
    public function getDailyAssismentReports(Request $request){
        $unitList=Unit::where('classroom_id',$request->classroomId)->get();
        $dailyAssignmentData=DailyAssignment::where('classroom_id',$request->classroomId)
        ->has('dailyReport')
        ->with('dailyQuestions.multipleChoice')
        ->get();

        return response()->json([
            'success'=>[
                'unitList'=>$unitList,
                'dailyAssignmentData'=>$dailyAssignmentData
            ]
        ]);
    }   
}
