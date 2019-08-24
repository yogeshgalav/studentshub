<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    //
    public function index(Request $request,$category_id)
    {
        $subjects=Subject::where('Subject_name','LIKE','%'.$request->subject.'%')->where('parent_id',$category_id)->limit(10)->get();
        return response()->json([
            'success'=>[
                'subjects'=>$subjects
            ]
        ]);
    }
}
