<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClassroomController extends Controller
{
    public function index(){
        return Inertia::render('classroom/ClassroomIndex');
    }
    public function show($id){
        return Inertia::render('classroom/ClassroomShow');
    }
    public function create(){
        return Inertia::render('classroom/ClassroomCreate');
    }
}
