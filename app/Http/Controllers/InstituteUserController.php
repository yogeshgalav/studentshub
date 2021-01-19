<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InstituteUser;
use App\Models\Institute;
use App\Models\Teacher;
use App\Models\ScheduledJob;
use DB;

class InstituteUserController extends Controller
{

    public function updateInstituteUser($instituteId,Request $request){
        if($request->user_id){
            $user = User::findOrFail($request->user_id);
            $ins_user = InstituteUser::where('user_id',$user->id)->where('institute_id',$instituteId)->first();
        }else if($user = User::where('email',$request->email)->first()){
            $ins_user = InstituteUser::firstOrNew([
                'user_id'=>$user->id,
                'institute_id'=>$instituteId
            ]);
        }else{
            $user = new User();
            $ins_user = new InstituteUser();
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            if($request->password){
                $user->password = \Hash::make($request->password);
                $user->must_reset_password=true;
            }
        }
        $user->role_intended = $request->role;
        $user->save();

        $ins_user->user_id = $user->id;
        $ins_user->institute_id = $instituteId;
        $ins_user->role = $request->role;
        $ins_user->save();
        
        if($request->role==='teacher'){
            $teacher = Teacher::firstOrCreate([
                'user_id' => $user->id,
                'institute_id' => $instituteId
            ]);
        }

        // ScheduledJob::scheduleNewInstituteMemberNotification($user);

        return response()->json('success');
    }
}
