<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Http\Requests\TeacherDailyAssignment\StoreRequest;
use App\Models\DailyAssignment;
use App\Models\DailyReport;
use App\Models\DailyQuestion;
use App\Models\Unit;
use DB;
use Log;
use Illuminate\Http\Request;

class DailyAssignmentController extends Controller
{
    //
    public function activateDailyAssignment(Request $request)
    {
        if($request->daily_assignment_id){
            DailyReport::where('daily_assignment_id',$request->daily_assignment_id)->exists() ? abort(403) : '';
        }
        $daily = DailyAssignment::findOrFail($request->daily_assignment_id);
        $marks=DailyQuestion::where('daily_assignment_id',$daily->id)->pluck('marks')->toArray();
        if(array_sum($marks)!==10){
            \Log::error('marks total error while activating daily assignment',['user_id'=>Auth::id(),'assignment'=>$daily]);
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
        if($request->daily_assignment_id){
            DailyReport::where('daily_assignment_id',$request->daily_assignment_id)->exists() ? abort(403) : '';
        }
        $daily = DailyAssignment::findOrFail($request->daily_assignment_id);

        $daily->delete();

        return response()->json('success');
    }

    public function updateDailyAssignment(Request $request)
    {    
        if($request->assignment_id){
            DailyReport::where('daily_assignment_id',$request->assignment_id)->exists() ? abort(403) : '';
        }
        $unit=Unit::findOrFail($request->unit_id);
        $is_assignment_duplicate = DailyAssignment::where('attempt_date',$request->attempt_date)
        ->where('classroom_id',$unit->classroom_id)
        ->where('id','!=',$request->assignment_id)
        ->exists();
        if($is_assignment_duplicate){
            return response()->json('Assignment with same date already exists.',422);
        }
        DB::beginTransaction();
    try{
        if($request->assignment_id){
            $dailyAssignment = DailyAssignment::find($request->assignment_id);     
        }else{
            $dailyAssignment = new DailyAssignment;
        }   
        $dailyAssignment->attempt_date=$request->attempt_date;
        $dailyAssignment->start_time=$request->start_time;
        $dailyAssignment->end_time=$request->end_time;
        $dailyAssignment->unit_id=$unit->id;
        $dailyAssignment->classroom_id=$unit->classroom_id;

        $dailyAssignment->save();

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('daily assignment update failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
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
        ->orderBy('attempt_date','DESC')
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
        $summary = DB::table('daily_assignments as da')
        ->where('da.classroom_id',$request->classroomId)
        ->leftjoin('daily_reports as dr','da.id','=','dr.daily_assignment_id')
        ->select(DB::raw('COUNT(distinct dr.user_id) as total_attende'),
                DB::raw('AVG(dr.marks_obtained) as average_score'),
                DB::raw('AVG(dr.duration) as average_duration')     
        )
        ->groupBy('da.id')
        ->get();
        return response()->json([
            'success'=>[
                'unitList'=>$unitList,
                'dailyAssignmentData'=>$dailyAssignmentData,
                'summary'=>$summary
            ]
        ]);
    }   
}
