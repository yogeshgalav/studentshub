<?php

namespace App\Http\Controllers;
use App\Models\Doubt;
use App\Models\DoubtRequest;
use App\Models\Subject;
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

        $subject_id=Subject::firstOrCreate([
            'subject_name'=>$request->subject
        ])->id;
        $batch_id=Auth::user()->student()->prefferred_batch;

        $q = new Doubt();
        $q->user_id = Auth::user()->id;
        $q->question = $request->doubt;
        $q->subject_id = $subject_id;
        $q->batch_id = $batch_id;
        $q->save();

        // switch($request->doubt_type){
        //     case 'batch':
        //         DoubtRequest::create([
        //             'doubt_id'=>$q->id,
        //             'doubtable_id'=>Auth::student()->prefferred_batch,
        //             'doubtable_type'=>'App\Models\Batch',
        //         ]);
        //     break;
        //     case 'branch':
        //         DoubtRequest::create([
        //             'doubt_id'=>$q->id,
        //             'doubtable_id'=>Auth::student()->prefferred_category,
        //             'doubtable_type'=>'App\Models\Branch',
        //         ]);
        //     break;
        // }
        
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
        $student=Auth::user()->student()->first();
        $branch=$student->prefferred_branch;
        $Doubts=Doubt::whereHas('subject.branch_subjects',function($query)use($branch){
            $query->where('bs.branch_id','=',$branch);
        })
        ->orWhere('doubts.batch_id',$student->prefferred_batch)
        ->get();

        return response()->json([
            'success'=>[
                'doubtList'=>$Doubts
            ]
        ]);
    }

}
