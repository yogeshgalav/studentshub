<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use App\Http\Controllers\Api\Session;
use App\Models\User;
use App\Models\UserPhone;
use Illuminate\Http\Response;
// use App\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\VerifyContactRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Carbon\Carbon;
use Auth;
use Session;
use DB;
use WhichBrowser\Parser;

class AuthController extends Controller
{
    
    public function verifyContact(VerifyContactRequest $request)
    {        
    //     $phone_number = PhoneNumber::make($request->input('phone_number'), 'IN')->formatE164();
        
        DB::beginTransaction();
    try{

        $user_phone=UserPhone::where('phone_number','=',$request->phone_number)->first();
        $user = $user_phone ? $user_phone->user : null;
        $otp_required = !(('local'===env('APP_ENV')) || ($user && $user->is_demo_account));

        //generate otp
        $otp = $otp_required ? rand(11111,99999) : 12345;

        // dd(env('APP_ENV'));

        $success = [];
        $success['new_user']=false;
        if(empty($user_phone) || empty($user)){
            $success['new_user'] = true;
        }
        if(empty($user_phone)){
            $user_phone=new UserPhone();
            $user_phone->phone_number=$request->phone_number;
            $user_phone->expires_at = Carbon::now()->toDateTimeString();
            
        }

        $user_phone->otp=Hash::make($otp);
        // $user_phone->otp=$otp;
        $user_phone->save();
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
    public function loginViaOtp(LoginRequest $request)
    {
        $result = new Parser($request->header('User-Agent'));
        Session::flush();
        $user_phone = UserPhone::where('phone_number', '=', $request->phone_number)->first();
        $user = $user_phone ? $user_phone->user : null;

        if (!$user) {
            Log::critical('user not found during login', ['phone_number' => $request->phone_number]);
            return response()->json(['srvError', 1], 500);
        }
    
        if (!Hash::check($request->otp, $user_phone->otp)) {
            return response()->json(['otpError', 1], 401);
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
        $user_phone = UserPhone::where('phone_number', '=', $request->phone_number)->first();
        $user = $user_phone ? $user_phone->user : null;
        
        if ($user) {
            Log::critical('user found during registration'.['phone_number' => $request->phone_number]);
        }

        if (!Hash::check($request->otp , $user_phone->otp)) {
            return response()->json(['otpError', 1], 401);
        }
        DB::beginTransaction();
        try {
            $user = new User;
            $user->full_name = $request->full_name;
            $user->fcm_token = $request->fcm_token;
            $user->phone_id = $user_phone->id;
            $user->save();

            DB::commit();
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

        return $user->createToken($request->header('User-Agent'))->plainTextToken;
    }

}
