<?php

namespace App\Http\Controllers;
use App\Models\Classroom;
use App\Models\ClassroomUser;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\JoinClassroomRequest;

class ClassroomUserController extends Controller
{
    //
    
    public function joinClassroom(Request $request){
        $classroom=Classroom::where('classroom_live_id',$request->name)->first();

        ClassroomUser::firstOrCreate([
            'user_id'=>Auth::id(),
            'classroom_id'=>$classroom->id
        ]);

        return response()->json('success');
    }
    public function acceptJoinRequest(Request $request){

        $classroom_user = ClassroomUser::where('user_id',$request->user_id)->where('classroom_id',$request->classroom_id)->firstOrFail();
        $classroom_user->joined_at=now();
        $classroom_user->save();
        
        return response()->json(['success'=>[
            'classroom_user'=> $classroom_user,
           
        ]]);
    }
    public function getClassrromUserData(Request $request){

        $join_requests = ClassroomUser::where('joined_at',null)->where('classroom_id',$request->classroom_id)->get();
        $student_report = ClassroomUser::where('joined_at','!=',null)
        ->where('classroom_id',$request->classroom_id)
        ->leftJoin('users','users.id','=','classroom_users.user_id')
        ->select('users.id','users.full_name')
        ->get();

        return response()->json(['success'=>[
            'join_requests'=>$join_requests,
            'student_report'=>$student_report
        ]]);
    }
}
