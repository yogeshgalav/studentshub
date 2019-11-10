<?php

namespace App\Http\Controllers;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    
    public function addQuestion(Request $request)
    {
   $question=new Question;
   $question->id=2;
   $question->save();
   return 'success';
    }

}
