<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Api\Session;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Response;
// use App\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\VerifyContactRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Carbon\Carbon;
use App\Facades\Sthub;
use Auth;
use Session;
use DB;
use WhichBrowser\Parser;

class AuthController extends Controller
{
    
    public function verifyContact(VerifyContactRequest $request)
    {        
    //     $phone_number = PhoneNumber::make($request->input('phone_number'), 'IN')->formatE164();
        $device_info = new Parser($request->header('User-Agent'));
        $ip_info = geoip()->getLocation() ;
        
        DB::beginTransaction();
    try{

        $user_login=UserLogin::where('phone_number','=',$request->phone_number)->first();
        $user = $user_login ? $user_login->user : null;
        $otp_required = !(('local'===env('APP_ENV')) || ($user && $user->is_demo_account));

        //generate otp
        $otp = $otp_required ? rand(1111,9999) : 1234;

        // dd(env('APP_ENV'));

        $success = [];
        $success['new_user']=false;
        if(empty($user_login) || empty($user)){
            $success['new_user'] = true;
        }
        if(empty($user_login)){
            $user_login=new UserLogin();
            $user_login->phone_number=$request->phone_number;
            $user_login->expires_at = Carbon::now()->toDateTimeString();
            
        }
            $user_login->fcm_token = $request->fcm_token;
            $user_login->device_info = json_encode($device_info);
            $user_login->city = $ip_info->city;
            $user_login->state = $ip_info->state;
            $user_login->country = $ip_info->country;
            $user_login->timezone = $ip_info->timezone;
            $user_login->postal_code = $ip_info->postal_code;
            $user_login->ip = $request->ip();

        $user_login->otp=Hash::make($otp);
        // $user_login->otp=$otp;
        $user_login->save();
        if($otp_required){  
            $this->sendOtpMessage($otp,$request->phone_number);
        }
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('user verify contact failure with contact '.$request->phone_number);
        return response()->$e;
    }  

        return response()->json(['success' => $success]);
    }

    
    public function sendOtpMessage($otp,$contact){

        $fields = array(
            "variables_values" => $otp . " for getting started with Student's Hub. Enjoy educational networking!",
            "route" => "otp",
            "numbers" => $contact,
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($fields),
        CURLOPT_HTTPHEADER => array(
            "authorization: ".env('SMS_API_KEY'),
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
        ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            Log::critical('sms api call failure cURL Error #:' . $err);
            dd($err);
            throw new \Exception;
        }

        return true;
    }
    public function loginViaOtp(Request $request)
    {
        Session::flush();
        $user_login = UserLogin::where('phone_number', '=', $request->phone_number)->first();

        if (empty($user_login)) {
            Log::critical('user not found during login', ['phone_number' => $request->phone_number]);
            return response()->json(['srvError', 1], 500);
        }
    
        if (!Hash::check($request->otp, $user_login->otp)) {
            return response()->json(['otpError', 1], 401);
        }

        $user = User::where('login_id', '=', $user_login->id)->first();
        Auth::login($user, 1);

        Log::info('User Logged in',[
            'id'=>$user->id,
            'full_name'=>$user->full_name,
            'via App'=>$request->fcmToken ? true : false,
            'ip'=>$request->ip(),
        ]);

        return $user->createToken($request->header('User-Agent'))->plainTextToken;
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
        $user_login = UserLogin::where('phone_number', '=', $request->phone_number)->first();
        if (empty($user_login)) {
            Log::critical('user not found during login', ['phone_number' => $request->phone_number]);
            return response()->json(['srvError', 1], 500);
        }

        if (!Hash::check($request->otp , $user_login->otp)) {
            return response()->json(['otpError', 1], 401);
        }
        DB::beginTransaction();
        try {
            $user = User::where('login_id', '=', $user_login->id)->first();
            if(empty($user)){
                $user = new User;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->full_name = $request->first_name .' '. $request->last_name;
                $user->login_id = $user_login->id;
                $user->save();

                DB::commit();
            }else{
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->full_name = $request->first_name .' '. $request->last_name;
                $user->login_id = $user_login->id;
                $user->save();

                DB::commit();
            }

        } catch (\Exception $e) {
            dd($e->getMessage(),$e->getLine());
            DB::rollback();
            Log::critical('user registeration failure with contact '.$request->phone_number);
            return response()->json(['srvError', 1], 500);
        }
        Auth::login($user, 1);
        Log::info('New User Registered',[
            'id'=>$user->id,
            'full_name'=>$user->full_name,
            'via App'=>$request->fcmToken ? true : false,
            'ip'=>$request->ip(),
        ]);
        return redirect('/classrooms');
        // return $user->createToken($request->header('User-Agent'))->plainTextToken;
    }

}
