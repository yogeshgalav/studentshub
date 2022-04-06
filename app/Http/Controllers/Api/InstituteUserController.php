<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\InstituteUser;
use App\Models\Institute;
use App\Models\Teacher;
use App\Models\ScheduledJob;
use DB;
use Auth;
use Log;
use Carbon\Carbon;

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
        $user->preferred_institute_id = $instituteId;
        $user->role = $request->role==='teacher' ? 'teacher' : 'instituteAdmin';
        $user->save();

        $ins_user->user_id = $user->id;
        $ins_user->institute_id = $instituteId;
        $ins_user->role = $request->role;
        $ins_user->verified_by_user_id = $request->user('api')->id;
        $ins_user->save();

        // ScheduledJob::scheduleNewInstituteMemberNotification($user);

        return response()->json('success');
    }

    public function teacherCheckin(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();

        DB::beginTransaction();
        try {
            //create or get institute id
            if(!empty($input['institute_id'])){
                $institute = Institute::find($input['institute_id']);
            }else{
                $institute = Institute::create([
                    'name' => $input['institute_name'],
                    'added_by_user_id' => $user->id,
                    'country_code' => 'IN',
                    'is_verified' => false,
                ]);
            }

            $user->preferred_institute_id = $institute->id;
            $user->onboarded_at = Carbon::now()->toDateTimeString();
            $user->phone_no = $request->contact_number;
            $user->role = 'teacher';
            $user->save();

            InstituteUser::firstOrCreate([
                'institute_id'=>$institute->id,
                'user_id'=>$user->id,
            ]);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Teacher Registeration failure',['error'=>$e->getMessage()]);
            return response()->$e;
        }
        Log::info('New Teacher Registered',['contact_number'=>$request->contact_number]);

        $success['redirectUrl'] = '/classrooms';
        return response()->json(['success' => $success]);
    }

}
