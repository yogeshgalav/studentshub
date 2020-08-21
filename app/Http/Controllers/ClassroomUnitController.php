<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Unit;
use App\Models\Classroom;
use Illuminate\Support\Facades\Log;

class ClassroomUnitController extends Controller
{
    //
    public function updateUnit($classroomId,Request $request){
        $unit = Unit::updateOrCreate([
            'unit_name'=>$request->unit_name
        ],[
            'classroom_id'=>$classroomId,
            'unit_no'=>$request->unit_no
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
            Log::critical('Unit Activation failure: for user id#'.Auth::user()->id,$request->all());
            dd($e->getMessage(),$e->getLine());
            return response()->$e;
        }
        return response()->json(['success'=>[
            'activated_unit' => $classroom->activated_unit
        ]]);
    }

    public function deleteUnit($classroomId,Request $request){
        Unit::where('classroom_id',$classroomId)->where('unit_no',$request->unit_no)->delete();
        return response()->json('success');
    }
}
