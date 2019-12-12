<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\ConsultantFirmUser;
use App\Client;
use App\ClientUser;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\URL;
use App\PasswordReset;
use App\Http\Requests\RegisterRequest;
use Carbon\Carbon;
use Sthub;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Socialite;

class AuthController extends Controller
{
    /**
     * login api
     *
     * @param LoginRequest $request The HTTP request object
     *
     * @return Response
     */
    public function login(LoginRequest $request)
    {        
        if ($user=User::where('email',$request->email)->orWhere('phone',$request->email)->first()) {
            //condition for email verify
            if (Hash::check($request->password, $user->password)) {

                Auth::login($user, $request->remember);
                //log info
                Log::info($user->first_name." ".$user->last_name." (User ID # ".$user->id.") logged in from IP Address ".$request->ip());

                $success['token'] = $user->createToken('Sthub')->accessToken;
                
                // if (is_null($user->onboarded_at)) {
                //     $success['redirectUrl'] = '/checkin';
                // } else {
                //     $success['redirectUrl'] = '/';
                // }
                $success['redirectUrl'] = '/';
                return response()->json(['success' => $success]);
            }
        }
        Log::warning("An invalid attempt to login was made for user ".$request->email." from IP Address ".$request->ip());
        return response()->json(['error'=>'Unauthorised'], 401);
    }

    public function checkSubdomain($subdomain, $user)
    {
        switch (Sthub::getDomainPortal()) {
            case 'staffPortal':
                if (! (bool) $user->is_Sthub_staff) {
                    return false;
                }
                break;
            case 'consultantPortal':
                if (!ConsultantFirmUser::where('user_id', $user->id)->first()) {
                    return false;
                }
                break;
            case 'tenantPortal':
                if ($client = Client::where('subdomain', $subdomain)->first()) {
                    if (!$client_user=ClientUser::where('client_id', $client->id)->where('user_id', $user->id)->first()) {
                        return false;
                    }
                } else {
                    return false;
                }
                break;
        }
        return true;
    }

    /**
     * Register api
     *
     * @param Request $request The HTTP request object
     *
     * @return Response
     */
    public function studentRegister(RegisterRequest $request)
    {
        $input = $request->all();
        //create or get course id
            //if new course insert course_type and course_level
        //create or get institute id
        //create or get branch id
        //create or get batch id
        
        $success['token'] = $user->createToken('student')->accessToken;
        $success['redirectUrl'] = '/';
        return response()->json(['success' => $success]);
    }

    /**
     * details api
     *
     * @return Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
    public function SocialSignup($provider)
    {
        // Socialite will pick response data automatic 
        $user = Socialite::driver($provider)->stateless()->user();        return response()->json($user);
    }

    // Handling the forgot password email request
    public function processForgotPassword(ForgotPasswordRequest $request)
    {
        $user=User::whereContact($request->input('email'))->first();
        if ($user) {
            $token = PasswordReset::create([
                'user_id'=>$user->id,
                'token'=>uniqid(),
                'expires_at'=>Carbon::now()->addHour(),
            ]);

            Mail::to($request->input('email'))->send(new ResetPasswordMail($token, $request));
        }
        return response(['success'=>'Email sent.'], 200);
    }

    // Handling the request to reset the password
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'=>'required|min:6',
            'confirm_password'=>'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 433);
        }

        $token = $request->input('token');
        $dbToken= PasswordReset::where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$dbToken) {
            return response()->json(['error'=>'Wrong Token.'], 403);
        }

        $user=User::where('id', $dbToken->user_id);
        $user->update(['password'=>Hash::make($request->input('password'))]);

        return response()->json(['success'=>'Password Changed.'], 200);
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
