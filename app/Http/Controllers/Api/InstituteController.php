<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstituteController extends Controller
{
    public function index(){
        $institutes = Institute::all();
        return response()->json(['success'=>[
            'institutes'=>$institutes
          ]]);
    }
}