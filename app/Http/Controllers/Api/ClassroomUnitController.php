<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Unit;
use App\Models\Classroom;
use Illuminate\Support\Facades\Log;

class ClassroomUnitController extends Controller
{
    //
    //api end point for getting unit assisment data for students and teachers
    public function getClassroomUnitDetails(Request $request){
        $unitData=Unit::where('classroom_id',$request->classroomId)
        ->orderBy('units.unit_no','DESC')->get();

        $daily_assignment_status = DB::table('daily_assignments')
        ->where('classroom_id',$request->classroomId)
        ->select(DB::raw('COUNT(distinct daily_assignments.id) as assignmentCount'),'daily_assignments.status','unit_id')
        ->groupBy('status','unit_id')
        ->get();

        $summary = DB::table('classrooms as cl')
        ->where('cl.id',$request->classroomId)
        ->leftJoin('units', 'cl.id', '=', 'units.classroom_id')
        ->leftJoin('daily_assignments', 'cl.id', '=', 'daily_assignments.classroom_id')
        ->leftJoin('classroom_resources', 'cl.id', '=', 'classroom_resources.classroom_id')
        ->leftJoin('daily_reports', 'daily_assignments.id', '=', 'daily_reports.daily_assignment_id')
        ->select('units.id',DB::raw('COUNT(distinct daily_assignments.id) as assignmentCount'),DB::raw('AVG(daily_reports.marks_obtained) as averageScore'),DB::raw('COUNT(distinct classroom_resources.id) as resources'))
        ->groupBy('units.id')
        ->get();

        $bar_data = DB::table('daily_assignments as da')
        ->where('da.classroom_id',$request->classroomId)
        ->leftjoin('daily_reports as dr','dr.daily_assignment_id','=','da.id')
        ->select('da.unit_id',DB::raw('COUNT(distinct dr.user_id) as total_attendes'),DB::raw('AVG(dr.marks_obtained) as average_score'),
        'da.attempt_date')
        ->groupBy('da.unit_id','da.id','da.attempt_date')
        ->get();

        return response()->json([
            'success'=>[
                'unitData'=>$unitData,
                'summary'=>$summary,
                'daily_assignment_status'=>$daily_assignment_status,
                'pie_data'=>$pie_data,
                'bar_data'=>$bar_data,
            ]
        ]);
    }
    public function getUnitAssismentDetails(Request $request){
        $unitData=Unit::where('classroom_id',$request->classroomId)
        ->with('descriptiveQuestions')
        ->get();

        return response()->json([
            'success'=>[
                'unitData'=>$unitData
            ]
        ]);
    }

    public function updateUnit($classroomId,Request $request){
        $unit = Unit::updateOrCreate([
            'classroom_id'=>$classroomId,
            'unit_no'=>$request->unit_no
        ],[
            'unit_name'=>$request->unit_name
        ]);

        return response()->json([
            'success'=>[
                'unit'=>$unit
            ]
        ]);
    }

    public function activateUnit($classroomId,Request $request){
        $now = \Carbon\Carbon::now()->toDateTimeString();

        DB::beginTransaction();
    try{
        $classroom = Classroom::findOrFail($classroomId);
        if($classroom->activated_unit){
            Unit::where('classroom_id',$classroomId)->where('unit_no',$classroom->activated_unit)
            ->update([
                'deactivated_at'=>$now,
            ]);
        }

        if($classroom->activated_unit!==$request->unit_no){
            $unit=Unit::where('classroom_id',$classroomId)->where('unit_no',$request->unit_no)->first();
            $unit->update([
                'activated_at'=>$now,
            ]);

            $classroom->activated_unit = $unit->unit_no;
        }else{
            $classroom->activated_unit = null;
        }

        $classroom->save();

        DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Unit Activation failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
            // dd($e->getMessage(),$e->getLine());
            return response()->$e;
        }
        return response()->json(['success'=>[
            'activated_unit' => $classroom->activated_unit
        ]]);
    }
}
