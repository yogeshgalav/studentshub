<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    //
    public function index($category_id,Request $request)
    {
        $subjects=Subject::where('subject_name','LIKE','%'.$request->subject.'%')->limit(10)->get();
        return response()->json([
            'success'=>[
                'subjects'=>$subjects
            ]
        ]);
    }

    public function subjectList($category_id){
        $subjects=Subject::where('category_id',$category_id)->limit(10)->get();
        return response()->json([
            'success'=>[
                'subjects'=>$subjects
            ]
        ]);
    }
}
