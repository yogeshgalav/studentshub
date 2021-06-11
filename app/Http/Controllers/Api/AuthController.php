<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Mails\ResetPasswordMail;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classroom;
use App\Models\ClassroomStudent;
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
class AuthController extends Controller
{
    
    public function loginViaApi(LoginRequest $request)
    {        

        $user=User::where('email',$request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            abort(401);
        }
        
        try{
            
            $success = $this->getLoginSuccessData('api',$user,$request);
            
        }catch(\Exception $e){
            // dd($e->getMessage());
            Log::warning("An invalid attempt to login was made for user ".$request->email." from IP Address ".$request->ip());
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        return response()->json(['success' => $success]);
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

        $success['redirectUrl'] = '/classrooms';
        // if($user->joinedClassoomCount()>0 || Auth::teacher()){
        //     $success['redirectUrl'] = '/classrooms';
        // }
        $success['redirectUrl'] = session('url.intended') ?? $success['redirectUrl'];

        $success['student'] = Auth::student();
        $success['full_name'] = $user->full_name;
    
        return $success;
    }
    
    public function registerViaApi(RegisterRequest $request)
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

        $content=$this->getPassportTokens($request);
        if(empty($content->access_token) || empty($content->refresh_token)){
            $success['access_token'] = $user->createToken('sthub')->accessToken;;
            $success['refresh_token'] = '';
        }else{
            $success['access_token'] = $content->access_token;
            $success['refresh_token'] = $content->refresh_token;
        }
        Auth::login($user);
        //log info
        Log::info('new User '.$user->full_name." (User ID # ".$user->id.") registered and logged in from IP Address ".$request->ip());

        $success['redirectUrl'] = '/check-in';
        if($request->join_id){
            $this->registerWithClassrrom($user,$request->join_id);
            $success['redirectUrl'] = '/education-details';
        }
        // \App\Models\ScheduledJob::scheduleNewUserNotification($user);
        
    DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('user Registeration failure.',['input'=>$input]);
        // dd($e->getMessage(),$e->getLine()));
        return response()->$e;
    }        
        return response()->json(['success' => $success]);
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
        $student = Student::where('user_id',$user->id)->first();
        ClassroomStudent::create([
            'classroom_id'=>$classroom->id,
            'student_id'=>$student->id,
        ]);
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
            $newUser->name            = $user->getName();
            $newUser->email           = $user->getEmail();
            $newUser->login_provider_id       = $user->id;
            $newUser->login_provider_type       = $provider;
            $avatar_url=$user->getAvatar();
            if(filter_var($avatar_url, FILTER_VALIDATE_URL)){
                $fileContents = file_get_contents($user->getAvatar());
                $file['file_name']=$user->getId() . ".jpg";
                $file['file_path']='/uploads/profile/' . $file['file_name'];
                storage()->put($file['file_path'], $fileContents);
                $newUser->avatar_url       = $file['file_path'];
            }
            $newUser->save(); 
            
            if($newUser && $file){
                $newFile= new \App\Models\SthubFile();
                $newFile->fileable_id=$user->id;
                $newFile->fileable_type='App\Models\User';
                $newFile->file_ext=storage()->getMimeType($file['file_path']);
                $newFile->file_size=storage()->size($file['file_path']);
                $newFile->file_name=$file['file_name'];
                $newFile->user_id=$user->id;
                $newFile->save();
            }

            Auth::login($newUser);
        }

        return redirect()->to('/');
    }
    // Handling the forgot password email request
    public function processForgotPassword(ForgotPasswordRequest $request)
    {
        $user=User::where('email',$request->input('email'))->first();
        if ($user) {
            $token = PasswordReset::create([
                'user_id'=>$user->id,
                'token'=>uniqid(),
                'expires_at'=>Carbon::now()->addHour()->toDateTimeString(),
                'created_at'=>Carbon::now()->toDateTimeString(),
            ]);

            Mail::to($request->input('email'))->send(new ResetPasswordMail($token, $request));
        }
        return response(['success'=>'Email sent.'], 200);
    }

    // Handling the request to reset the password
    public function resetPassword2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'=>'required|min:8',
            'confirm_password'=>'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        $user=Auth::user();    
        $user->must_reset_password=0;
        $user->email_verified_at=Carbon::now()->toDateTimeString();
        $user->password=Hash::make($request->input('password'));
        $user->save();
        return response()->json(['success'=>'Password Changed.'], 200);
    }

    public function resetPassword($token,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'=>'required|min:8',
            'confirm_password'=>'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 433);
        }

        $dbToken= PasswordReset::where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$dbToken) {
            return response()->json(['error'=>'Wrong Token.'], 403);
        }

        $user=User::where('id', $dbToken->user_id)->first();
        if(empty($user->email_verified_at)){
            $user->email_verified_at=Carbon::now()->toDateTimeString();
        }
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json(['success'=>'Password Changed.'], 200);
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
