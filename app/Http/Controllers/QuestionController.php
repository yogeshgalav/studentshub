<?php

namespace App\Http\Controllers;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    
    public function addQuestion (Request $request)
    {
   $q = new Question();
   $q->question = $request->question;
   $q->save();
   return 'success';
    }
    public function getQuestion (Request $request)
    {
        $questions=Question::get();
        return response()->json([
            'success'=>[
                'questions'=>$questions
            ]
        ]);
    }

}
