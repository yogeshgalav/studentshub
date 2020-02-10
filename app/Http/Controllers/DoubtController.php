<?php

namespace App\Http\Controllers;
use App\Models\Doubt;
use App\Models\DoubtRequest;
use Illuminate\Http\Request;
use Auth;
use Arr;
use DB;

class DoubtController extends Controller
{
    
    public function addDoubt (Request $request)
    {
        $input = $request->all();
        DB::beginTransaction();
    try{
        $q = new Doubt();
        $q->user_id = Auth::user()->id;
        $q->question = $request->doubt;
        $q->save();

        switch($request->doubt_type){
            case 'batch':
                DoubtRequest::create([
                    'doubt_id'=>$q->id,
                    'doubtable_id'=>Auth::student()->prefferred_batch,
                    'doubtable_type'=>'batch',
                ]);
            break;
            case 'category':
                DoubtRequest::create([
                    'doubt_id'=>$q->id,
                    'doubtable_id'=>Auth::student()->prefferred_category,
                    'doubtable_type'=>'category',
                ]);
            break;
        }
        
    DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::critical('Doubt Creation failure: for user id#'.Auth::user()->id.' with data '.implode(', ',Arr::flatten($input)));
            dd($e->getMessage(),$e->getLine());
            return response()->$e;
        }        
        return 'success';
    }

    public function getDoubts(Request $request)
    {
        $Doubts=\DB::table('doubts')
        ->leftJoin('doubt_requests as dr','dr.doubt_id','=','doubts.id')
        ->where(function($query){
            $query->where('dr.doubtable_type','batch')->where('dr.doubtable_id',1);
        })
        // ->orWhere(function($query){
        //     $query->where('doubtable_type','classroom')->whereIn('doubtable_id',Auth::student()->classrooms()->pluck('id'));
        // })
        // ->orWhere(function($query){
        //     $query->where('dr.doubtable_type','category')->where('dr.doubtable_id',Auth::student()->preffered_category);
        // })
        ->get();

        return response()->json([
            'success'=>[
                'doubtList'=>$Doubts
            ]
        ]);
    }

}
