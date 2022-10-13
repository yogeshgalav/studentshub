<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index(){
        $subjects = Subject::all();
        return response()->json(['success'=>[
            'subjects'=>$subjects
          ]]);
    }
}