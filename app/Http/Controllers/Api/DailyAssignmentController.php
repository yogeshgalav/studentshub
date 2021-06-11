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
use App\Notfications\NewDailyAssignmentNotification;
use App\Http\Requests\DailyAssignmentRequest;

class DailyAssignmentController extends Controller
{
    //
    public function activate(DailyAssignment $daily_assignment)
    {
        $this->authorize('update', $daily_assignment);
        if($daily_assignment->activated_at){
            $daily_assignment->activated_at = now()->toDateTimeString();
            $daily_assignment->status = 'activated';
        }else{
            $daily_assignment->activated_at = null;
            $daily_assignment->status = 'draft';
        }
        $daily_assignment->save();

        return response()->json('success');
    }

    public function delete(DailyAssignment $daily_assignment)
    {
        $this->authorize('delete', $daily_assignment);

        $daily_assignment->delete();
        return response()->json('success');
    }

    public function create(Classroom $classroom, CreateAssignmentRequest $request)
    {

        DB::beginTransaction();
    try{
        $dailyAssignment = new DailyAssignment;
        $dailyAssignment->attempt_date=$request->attempt_date;
        $dailyAssignment->unit_id=$unit->id;
        $dailyAssignment->classroom_id=$unit->classroom_id;

        $dailyAssignment->save();

        DB::commit();
    } catch (\Exception $e) {dd($e->getMessage());
        DB::rollback();
        Log::critical('daily assignment update failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
        return response()->$e;
    }
        return response()->json(['success'=>[
            'assignment'=>$dailyAssignment
        ]]);

    }
    public function update(DailyAssignment $dailyAssignment, UpdateAssignmentRequest $request)
    {
        DB::beginTransaction();
    try{

        $dailyAssignment->attempt_date=$request->attempt_date;
        $dailyAssignment->start_time=$request->start_time;
        $dailyAssignment->end_time=$request->end_time;
        $dailyAssignment->unit_id=$unit->id;

        $dailyAssignment->save();

        DB::commit();
    } catch (\Exception $e) {dd($e->getMessage());
        DB::rollback();
        Log::critical('daily assignment update failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
        return response()->$e;
    }
        return response()->json(['success'=>[
            'assignment'=>$dailyAssignment
        ]]);

    }

    public function getAssignmentList(Request $request){
        $unitList=Unit::where('classroom_id',$request->classroomId)->get();
        $assignment_list=DailyAssignment::where('classroom_id',$request->classroomId)
        ->orderBy('attempt_date','DESC')
        ->select('id','unit_id','attempt_date', 'start_time', 'end_time','activated_at')
        ->withCount('dailyReports')
        ->get();

        return response()->json([
            'success'=>[
                'unitList'=>$unitList,
                'assignment_list'=>$assignment_list
            ]
        ]);
    }
}
