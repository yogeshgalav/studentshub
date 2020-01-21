<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    //
    public function index($category_id,Request $request)
    {
        $subjects=Subject::where('Subject_name','LIKE','%'.$request->subject.'%')->where('parent_id',$category_id)->limit(10)->get();
        return response()->json([
            'success'=>[
                'subjects'=>$subjects
            ]
        ]);
    }

    public function subjectList($category_id){
        $subjects=Subject::where('parent_subject_id',$category_id)->limit(10)->get();
        return response()->json([
            'success'=>[
                'subjects'=>$subjects
            ]
        ]);
    }
}
