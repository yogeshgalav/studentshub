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
use DB;
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

        try{
            $client = DB::table('oauth_clients')
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
            $content = json_decode(app()->handle($request)->getContent());
            
            if(!empty($content->error)){
                throw new \Exception;
            }
            $user=User::where('email',$request->email)->first();
            Auth::login($user, $request->remember);
            //log info
            Log::info($user->full_name." (User ID # ".$user->id.") logged in from IP Address ".$request->ip());

            $success['redirectUrl'] = '/';
            $success['access_token'] = $content->access_token;
            $success['refresh_token'] = $content->refresh_token;
            
        }catch(\Exception $e){
            Log::warning("An invalid attempt to login was made for user ".$request->email." from IP Address ".$request->ip());
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        return response()->json(['success' => $success]);
    }

    /**
     * Register api
     *
     * @param Request $request The HTTP request object
     *
     * @return Response
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        
        $input['full_name']=trim($input['full_name']);
        //hash password
        $input['password'] = bcrypt($input['password']);

        DB::beginTransaction();
    try{
        $user = User::create([
            'full_name'=>$input['full_name'],
            'email'=>$input['email'],
            'password'=>$input['password'],
        ]);

        $client = DB::table('oauth_clients')
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
        $content = json_decode(app()->handle($request)->getContent());
        
        if(!empty($content->error)){
            throw new \Exception;
        }

        Auth::login($user);
        //log info
        Log::info('new User '.$user->full_name." (User ID # ".$user->id.") registered and logged in from IP Address ".$request->ip());

        $success['access_token'] = $content->access_token;
        $success['refresh_token'] = $content->refresh_token;
                
        $success['redirectUrl'] = '/check-in';
        
    DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('user Registeration failure: with data '.implode(',',$input));
        return response()->$e;
    }        
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
    /**
     * Redirect the user to the Google authentication page.
    *
    * @return \Illuminate\Http\Response
    */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
   /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            // log them in
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->login_provider_id       = $user->id;
            $newUser->login_provider_type       = $provider;
            $newUser->avatar          = $user->avatar;
            $newUser->avatar_original = $user->avatar_original;
            $newUser->save();
            auth()->login($newUser, true);
        }
        return redirect()->to('/');
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
        $access_token=Auth::user()->token();

        $refreshToken=DB::table('oauth_refresh_tokens')
        ->where('access_token_id',$access_token->id)
        ->update(['revoked'=>true]);

        $access_token->revoke();

        Auth::logout();
        return redirect('/');
    }
}
