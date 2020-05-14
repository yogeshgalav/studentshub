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
        $student=Auth::student();
        
        if(is_null($student)){
            abort(403);
        }

        DB::beginTransaction();
    try{

        $subject_name=strtolower($request->subject);
        $subject=Subject::firstOrCreate([
            'subject_url'=>urlencode($subject_name),
            ],[
            'Subject_name'=>$subject_name,
            'category_id'=>$student->categoryId
            ]);  

        $q = new Doubt();
        $q->user_id = Auth::user()->id;
        $q->question = $request->doubt;
        $q->subject_id = $subject->id;
        $q->batch_id = $student->batchId;
        $q->save();

        
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
        $student=Auth::student();
        $Doubts=Doubt::whereHas('subject.course_subjects',function($query)use($student){
            $query->where('course_id','=',$student->courseId);
        })
        ->orWhere('batch_id',$student->batchId)
        ->get();

        return response()->json([
            'success'=>[
                'doubtList'=>$Doubts
            ]
        ]);
    }

}
