<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    //
    public function classroomListPage(){
        return view('classroom.classroom-list');
    }

    public function classroomPage($classroomId){
        $classroom=Classroom::findOrFail($classroomId);
        if($classroom->teacher()->user()->id===Auth::id()){
            return view('classroom.classroom');    
        }
        return view('classroom.my-panel');
    }
    
    public function studentPanelPage(){
        return view('classroom.student-panel');
    }

    public function topicAnswersPage(){
        return view('classroom.topic-answers');
    }
}
