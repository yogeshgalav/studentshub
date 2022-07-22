<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\ChatroomUser;
use App\Models\Classroom;
use App\Models\User;
use App\Models\UserPhone;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function getStartedPage(Request $request)
    {
        if (Auth::check()) {
            return redirect('/');
        }
        $srv_error = Session::get('srvError');
        $otp_error = Session::get('otpError');
        Session::forget('srv_error');
        Session::forget('otpError');
        if($request->chatId){
            Session::put('chatId', $request->chatId);
        }
        if($request->inId){
            Session::put('inId', $request->inId);
        }

        return inertia('auth/get-started', [
            'srvError' => $srv_error ? 1 : 0,
            'otpError' => $otp_error ? 1 : 0,
        ]);
    }

    public function loginViaOtp(LoginRequest $request)
    {
        Session::flush();
        $user_phone = UserPhone::where('phone_no', '=', $request->phone_number)->first();
        $user = $user_phone ? $user_phone->user : null;

        if (!$user) {
            Log::critical('user not found during login', ['phone_number' => $request->phone_number]);
            return redirect('/get-started')->with('srvError', 1);
        }

        if (!Hash::check($request->otp, $user_phone->otp)) {
            return redirect('/get-started')->with('otpError', 1);
        }

        $success['redirectUrl'] = '/';
        if ($user->role === 'sthub_staff') {
            $success['redirectUrl'] = '/manage-users';
        }
        if ($request->chatId) {
            ChatroomUser::updateOrCreate([
                'chatroom_id' => $request->chatId,
                'user_id' => $user->id,
            ]);
            $success['redirectUrl'] = '/chatrooms';
        }
        if ($request->inId) {
            $user->preferred_institute = $request->inId;
            $user->save();
            $success['redirectUrl'] = '/my-institute';
        }
        if ($request->fcmToken) {
            $user->fcm_token = $request->fcmToken;
            $user->save();
        }

        Auth::login($user, 1);

        Log::info('User Logged in',[
            'id'=>$user->id,
            'full_name'=>$user->full_name,
            'via App'=>$request->fcmToken ? true : false,
            'ip'=>$request->ip(),
        ]);

        return redirect($success['redirectUrl']);
    }

    /**
     * Register api.
     *
     * @param Request $request The HTTP request object
     *
     * @return Response
     */
    public function registerViaOtp(RegisterRequest $request)
    {
        Session::flush();
        $user_phone = UserPhone::where('phone_no', '=', $request->phone_number)->first();
        $user = $user_phone ? $user_phone->user : null;
        
        if ($user) {
            Log::critical('user found during registration'.['phone_number' => $request->phone_number]);
        }

        if (!Hash::check($request->otp, $user_phone->otp)) {
            return redirect('/get-started')->with('otpError', 1);
        }
        DB::beginTransaction();
        try {
            $input = $request->all();
            $user = new User;
            $user->full_name = $input['full_name'];
            $user->role = $input['role'];
            $user->email = $input['email'] ?? null;
            $user->fcm_token = $request->fcm_token;
            $user->phone_id = $user_phone->id;
            $user->onboarded_at = \Carbon\Carbon::now()->toDateTimeString();
            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('user registeration failure with contact '.$request->phone_number);

            return redirect('/get-started')->with('srvError', 1);
        }
        Auth::login($user, 1);
        Log::info('New User Registered',[
            'id'=>$user->id,
            'full_name'=>$user->full_name,
            'via App'=>$request->fcmToken ? true : false,
            'ip'=>$request->ip(),
        ]);
        $success['redirectUrl'] = '/';

        DB::beginTransaction();
        try {
            if ($request->chatId) {
                ChatroomUser::updateOrCreate([
                    'chatroom_id' => $request->chatId,
                    'user_id' => $user->id,
                ]);
                $success['redirectUrl'] = '/chatrooms';
            }
            if ($request->inId) {
                $user->preferred_institute = $request->inId;
                $user->save();
                $success['redirectUrl'] = '/my-institute';
            }
            if ($request->fcmToken) {
                $user->fcm_token = $request->fcmToken;
                $user->save();
            }
            if ($request->join_id) {
                $this->registerWithClassrrom($user, $request->join_id);
                $success['redirectUrl'] = '/classrooms';
            }
            \App\Models\ScheduledJob::scheduleNewUserNotification($user);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('user further registeration failure with contact '.$request->phone_number);
        }

        return redirect($success['redirectUrl']);
    }

    public function registerWithClassrrom($user, $joinId)
    {
        $classroom = Classroom::where('classroom_join_id', $joinId)->first();
        if (empty($classroom)) {
            Log::error('Classroom not found for joining.', ['user_id' => $user->id, 'join_id' => $joinId]);

            return false;
        }
        try {
            $user->joinClassroom($classroom);
        } catch (\Exception $e) {
            Log::error('registeration with classroom failure.', ['user_id' => $user->id, 'classroom_id' => $classroom->id, 'error' => $e]);
        }
        try {
            $job = new \App\Jobs\NewUserNotificationJob($user, $classroom);
            $this->dispatch($job);
        } catch (\Exception $e) {
            Log::error('NewUserNotificationJob failure.', ['user_id' => $user->id, 'classroom_id' => $classroom->id, 'error' => $e]);
        }

        return true;
    }

    public function logout()
    {
        try {
        $access_token = DB::table('oauth_access_tokens')
        ->where('user_id', Auth::user()->id)
        ->update(['revoked' => true]);

        $refreshToken = DB::table('oauth_refresh_tokens')
        ->where('access_token_id', $access_token->id)
        ->update(['revoked' => true]);
        } catch (\Exception $e) {
        }
        $rememberMeCookie = Auth::getRecallerName();
        $cookie = Cookie::forget($rememberMeCookie);
        Auth::logout();
        Session::flush();

        return redirect('/')->withCookie($cookie);
    }

    public function refresh(Request $request)
    {
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => '',
        ];

        $request = Request::create('/oauth/token', 'POST', $data);
        $content = json_decode(app()->handle($request)->getContent());
        if (empty($content->access_token) || empty($content->refresh_token)) {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
        Auth::login($user);

        $success['token'] = $content->access_token;
        $success['refresh_token'] = $content->refresh_token;
        $success['redirectUrl'] = $this->loginRedirectUrl;

        return response()->json(['success' => $success]);
    }

    public function getPassportTokens($request)
    {
        $client = DB::table('oauth_clients')
            ->where('password_client', true)
            ->first();

        $data = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*',
        ];

        $request = Request::create('/oauth/token', 'POST', $data);

        return json_decode(app()->handle($request)->getContent());
    }
}
