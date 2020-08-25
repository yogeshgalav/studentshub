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
    public function userRequestAction(Request $request){

        $classroom_user = ClassroomUser::where('user_id',$request->user_id)->where('classroom_id',$request->classroom_id)->firstOrFail();
        if($request->status==='accept'){
            $classroom_user->joined_at=now();
            $classroom_user->save();
        }
        if($request->status==='decline'){
            $classroom_user->delete();
        }
        return response()->json(['success'=>[
            'classroom_user'=> $classroom_user,
        ]]);
    }
    public function getClassrromUserData($classroom_id){

        $student_details = \DB::table('classroom_users as csu')
        ->where('csu.classroom_id',$classroom_id)
        ->join('users','users.id','=','csu.user_id')
        ->select('users.id as user_id','users.full_name as user_name','csu.joined_at')
        ->get();

        return response()->json(['success'=>[
            'student_details'=>$student_details
        ]]);
    }
}
