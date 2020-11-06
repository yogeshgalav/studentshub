<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InstituteUser;
use App\Models\Institute;
use App\Models\Teacher;
use DB;

class InstituteUserController extends Controller
{
    public function showInstituteUsers($instituteId){
        $institute_detail = Institute::findOrFail($instituteId);

        $users=DB::table('institute_users as inu')->where('inu.institute_id',$instituteId)
        // ->join('institute_users as inu2',function($join){
        //     $join->on('inu2.institute_id','=','inu.institute_id')->where('inu2.user_id','=',Auth::id());
        // })
        ->join('users as us','us.id','=','inu.user_id')
        ->select('us.id','us.full_name','us.email','inu.role')
        ->get();

        return response()->json([
            'success'=>[
                'institute_detail'=>$institute_detail,
                'users'=>$users
            ]
        ],200);
    }

    public function updateInstituteUser($instituteId,Request $request){
        if($request->user_id){
            $user = User::findOrFail($request->user_id);
            $ins_user = InstituteUser::where('user_id',$user->id)->where('institute_id',$instituteId)->first();
        }else{
            $user = new User();
            $ins_user = new InstituteUser();
        }

        $user->role_intended = $request->role;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        if($request->password){
            $user->password = \Hash::make($request->password);
            $user->must_reset_password=true;
        }
        $user->save();
        
        $ins_user->user_id = $user->id;
        $ins_user->institute_id = $instituteId;
        $ins_user->role = $request->role;
        $ins_user->save();
        
        if(empty($request->user_id) && $request->role==='teacher'){
            $teacher = new Teacher();
            $teacher->user_id = $user->id;
            $teacher->institute_id = $instituteId;
            $teacher->save();
        }

        return response()->json('success');
    }
}
