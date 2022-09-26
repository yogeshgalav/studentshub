<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index(){
        return Inertia::render('classroom/ClassroomIndex');
    }
     public function show(){
        return Inertia::render('classroom/ClassroomShow');
     }
}
