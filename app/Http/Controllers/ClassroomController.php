<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClassroomController extends Controller
{
    public function index(){
        $classrooms = Classroom::with('category','course', 'subject','institute')->get();
        return Inertia::render('classroom/ClassroomIndex',['classrooms' => $classrooms]);
    }
    public function show($id){
        $classroom = Classroom::findOrFail($id)
        ->with(['category','course', 'subject','institute'])
        ->first();
        return Inertia::render('classroom/ClassroomShow',['classroom' => $classroom]);
    }
    public function create(){
        return Inertia::render('classroom/ClassroomCreate');
    }
}
