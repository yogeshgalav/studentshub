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
        $unitData=Unit::where('classroom_id',$request->classroomId)->get();

        return response()->json([
            'success'=>[
                'unitData'=>$unitData
            ]
        ]);
    }   
    public function getUnitAssismentDetails(Request $request){
        $unitData=Unit::where('classroom_id',$request->classroomId)
        ->with('descriptiveQuestions')
        ->get();
        $pie_details = DB::table('units as ut')
        ->where('ut.classroom_id',$request->classroomId)
        ->leftjoin('daily_assignments as da','ut.classroom_id','=','da.classroom_id')
        ->leftjoin('daily_reports as dr','dr.daily_assignment_id','=','da.id')
        ->select('ut.id','da.id',DB::raw("SUM(CASE WHEN (dr.status = 'completed') THEN 1 ELSE 0 END) as total_completed"),
        DB::raw("SUM(CASE WHEN (dr.status = 'draft') THEN 1 ELSE 0 END) as total_draft"),
        DB::raw("SUM(CASE WHEN (dr.status = 'activated') THEN 1 ELSE 0 END) as total_activated")     
        )
        ->groupBy('ut.id','da.id')
        ->get();
        return response()->json([
            'success'=>[
                'unitData'=>$unitData,
                'pie_data'=>$pie_details
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
