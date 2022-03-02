<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Mails\ResetPasswordMail;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classroom;
use App\Models\ClassroomUser;
use Illuminate\Http\Response;
use App\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\RegisterRequest;
use Carbon\Carbon;
use Sthub;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Socialite;
use DB;
class LoginController extends Controller
{
    
    public function sendOtp(LoginRequest $request)
    {        
        $user=User::where('phone_no',$request->phone_number)->first();
        $user->otp = rand();

        return response()->json([
            'is_user_registered'=>$user ? true : false,
        ]);
    }

    public function verifyOtp(LoginRequest $request)
    {        
        $user=User::where('phone_no',$request->phone_number)
        ->where('otp',$request->otp)->first();

        if (!$user) {
            Log::info("An invalid otp was entered for user ".$request->phone_number." from IP Address ".$request->ip());
            abort(401);
        }

        $success = $this->getLoginSuccessData('api',$user,$request);

        return response()->json([
            'success'=>$success,
        ]);
    }

    public function registerUser(LoginRequest $request)
    {        
        $user=User::where('phone_no',$request->phone_number)->first();

        if ($user) {
            return redirect('/get-started')->with('otpError',1);
        }

        $input = $request->all();
        
        $input['full_name']=trim($input['full_name']);

        DB::beginTransaction();
    try{
        $user = User::create([
            'full_name'=>$input['full_name'],
            'phone_no'=>$input['phone_number'],
            'role_intended'=>$input['role'],
            'fcm_token'=>$request->fcmToken ?? null,
        ]);

        // $service = new LoginService();
        // $service->attemptLogin();
    
        Auth::login($user);
        //log info
        Log::info('new User '.$user->full_name." (User ID # ".$user->id.") registered and logged in from IP Address ".$request->ip());

        $success['redirectUrl'] = '/';
        if($request->join_id){
            $this->registerWithClassrrom($user,$request->join_id);
        }
        \App\Models\ScheduledJob::scheduleNewUserNotification($user);
        
        if (!empty($request->fcmToken)) {
            $user->fcm_token=$request->fcmToken;
        }        

        return redirect($success['redirectUrl']);
    
        DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('user Registeration failure',['request_data'=>$input,'error'=>$e->getMessage()]);
            return redirect('/get-started');
        }  

        return redirect($success['redirectUrl']);
}


    public function getLoginSuccessData($method,$user,$request){
        $success = [];
        
        if('api' === $method){
            if ($request->remember) {
                Passport::tokensExpireIn(now()->addDay(30));
                // Passport::refreshTokensExpireIn(now()->addDay(30));
            }else{
                Passport::tokensExpireIn(now()->addHour(3));
                // Passport::refreshTokensExpireIn(now()->addHour());
            }

            $content=$this->getPassportTokens($request);
            if(empty($content->access_token) || empty($content->refresh_token)){
                $success['access_token'] = $user->createToken('sthub')->accessToken;;
                $success['refresh_token'] = '';
            }else{
                $success['access_token'] = $content->access_token;
                $success['refresh_token'] = $content->refresh_token;
            }
        }
        $user->last_login_at=\Carbon\Carbon::now()->toDateTimeString();
        $user->save();
    
        Auth::login($user, $request->remember);
        //log info
        Log::info($user->full_name." (User ID # ".$user->id.") logged in from IP Address ".$request->ip());

        $success['redirectUrl'] = '/categories';
        $success['redirectUrl'] = session('url.intended') ?? $success['redirectUrl'];
        return $success;
    }

    public function registerWithClassrrom($user,$joinId){
        $classroom = Classroom::where('classroom_join_id',$joinId)->first();
        if(empty($classroom)){
            return false;
        }
        $request = new Request([
            'course_id' => $classroom->course_id,
            'institute_id' => $classroom->institute_id, 
            'institute_name' => '',
        ]);
        $student_controller =new \App\Http\Controllers\Api\StudentController;
        $student_controller->create($request);
        
        ClassroomUser::create([
            'classroom_id'=>$classroom->id,
            'user_id'=>$user->id,
        ]);
    }
}
