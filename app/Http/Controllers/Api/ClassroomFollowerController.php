<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassroomFollower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomFollowerController extends Controller
{

    public function create(Request $request){

        $classroomFollower=new ClassroomFollower;
        $classroomFollower->classroom_id = $request->classroom_id;
        $classroomFollower->follower_user_id = Auth::user()->id;
        $classroomFollower->save();

        return response()->json(['success'=>[
            'message'=>'Classroom Successfully Followed',
          ]]);

    }

    public function delete(Request $request){

        $classroomFollower = $request->id;
        $classroomFollower->delete();
        return response()->json(['success'=>[
            'message'=>'Classroom Successfully unfollowed'
          ]]);

    }

}