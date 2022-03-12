<?php

namespace App\Http\Controllers;

use App\Mails\ResetPasswordMail;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Response;
use App\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StudentCreateRequest;
use Carbon\Carbon;
use Sthub;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Socialite;
use DB;

class AuthController extends Controller
{
    public function getStartedPage()
    {
        if(Auth::check()){
            return redirect('/');
        }
        return inertia('auth/get-started')->with([
            'srvError'=>session('srvError') ?? 1,
            'otpError'=>session('otpError') ?? 1,
        ]);
    }

    public function loginViaOtp(Request $request){
        \Session::flush();     
        $user=User::where('phone_no','=',$request->phone_number)->first();

        if(!$user){
            Log::critical('user not find during login'.['phone_number'=>$request->phone_number]);
        }
        if(!Hash::check($request->otp,$user->password)){
            return redirect('/get-started')->with('otpError',1);
        }
        Auth::login($user,1);

        Log::info($user->full_name." (User ID # ".$user->id.") logged in from IP Address ".$request->ip());

        return redirect('/');
    }

    /**
     * Register api
     *
     * @param Request $request The HTTP request object
     *
     * @return Response
     */
    public function registerViaOtp(Request $request)
    {
        \Session::flush();
        $user=User::where('phone_no','=',$request->phone_number)->first();

        if(!$user){
            Log::critical('user not find during registration'.['phone_number'=>$request->phone_number]);
        }

        if(!Hash::check($request->otp,$user->password)){
            return redirect('/get-started')->with('otpError',1);
        }

        DB::beginTransaction();
    try{

        $fcm_token=null;
        if (!empty($request->fcmToken)) {
            $fcm_token=base64_decode($request->fcmToken);
        }

        $input = $request->all();
        $user->full_name = $input['full_name'];
        $user->role = $input['role'];
        $user->email = $input['email'] ?? null;
        $user->fcm_token = $fcm_token;
        $user->onboarded_at=\Carbon\Carbon::now()->toDateTimeString();
        $user->save();
        
        Auth::login($user,1);
        Log::info($user->full_name." (User ID # ".$user->id.") registered and logged in from IP Address ".$request->ip());

        $success['redirectUrl'] = '/';
        if($request->join_id){
            $this->registerWithClassrrom($user,$request->join_id);
            $success['redirectUrl'] = '/classrooms';
        }

        \App\Models\ScheduledJob::scheduleNewUserNotification($user);

        DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
             
            Log::critical('user registeration failure with contact '.$request->phone_number);
            return redirect('/get-started')->with('srvError',1);
        }  

        return redirect('/');
    }

    public function registerWithClassrrom($user,$joinId){
        $classroom = Classroom::where('classroom_join_id',$joinId)->first();
        if(empty($classroom)){
            Log::error('Classroom not found for joining.',['user_id'=>$user->id,'join_id'=>$joinId]);
            return false;
        }
        try{
            $user->joinClassroom($classroom);    
        } catch (\Exception $e) {
            Log::error('registeration with classroom failure.',['user_id'=>$user->id,'classroom_id'=>$classroom->id,'error'=>$e]);
        }
        try{
            $job = new \App\Jobs\NewUserNotificationJob($user, $classroom);
            $this->dispatch($job);
        } catch (\Exception $e) {
            Log::error('NewUserNotificationJob failure.',['user_id'=>$user->id,'classroom_id'=>$classroom->id,'error'=>$e]);
        }
        return true;
    }
    
    public function logout(){
        try{
            
        $access_token=DB::table('oauth_access_tokens')
        ->where('user_id',Auth::user()->id)
        ->update(['revoked'=>true]);

        $refreshToken=DB::table('oauth_refresh_tokens')
        ->where('access_token_id',$access_token->id)
        ->update(['revoked'=>true]);

        }catch(\Exception $e){

        }
        $rememberMeCookie = Auth::getRecallerName();
        $cookie = \Cookie::forget($rememberMeCookie);
        Auth::logout();
        \Session::flush();
        return redirect('/')->withCookie($cookie);
    }

    public function refresh(Request $request){
        $client = \DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => ''
        ];

        $request = Request::create('/oauth/token', 'POST', $data);
        $content= json_decode(app()->handle($request)->getContent());
        if(empty($content->access_token) || empty($content->refresh_token)){
            return response()->json(['error' => 'Unauthorised'], 401);
        }
        Auth::login($user);
        
        $success['token'] = $content->access_token;
        $success['refresh_token'] = $content->refresh_token;
        $success['redirectUrl']= $this->loginRedirectUrl;
        return response()->json(['success'=>$success]);
    }

    
    public function getPassportTokens($request){
        $client = \DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*'
        ];

        $request = Request::create('/oauth/token', 'POST', $data);
        return json_decode(app()->handle($request)->getContent());
    }
}
