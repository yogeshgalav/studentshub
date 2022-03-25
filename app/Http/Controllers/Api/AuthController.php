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
use App\Http\Requests\VerifyContactRequest;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\RegisterRequest;
use Carbon\Carbon;
use Sthub;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Socialite;
use DB;
use App\Models\Lead;

class AuthController extends Controller
{
    
    public function verifyContact(VerifyContactRequest $request)
    {        
    //     $phone_number = PhoneNumber::make($request->input('phone_number'), 'IN')->formatE164();
        
        DB::beginTransaction();
    try{
       
        $user=User::where('phone_no','=',$request->phone_number)->first();
        
        //generate otp
        $otp = ('local'===env('APP_ENV')) ? 12345 : $otp=rand(11111,99999);;

        $success = [];
        $success['new_user']=false;
        if(empty($user)){
            $user=new User();
            $user->country_code = $request->country_code;
            $user->phone_no=$request->phone_number;
        }else if($user->role==='staff'){
            $otp=12345;
        }

        $user->password=Hash::make($otp);
        $user->save();
        
        if(empty($user->onboarded_at)){
            $success['new_user'] = true;
        }
        
        // $this->sendOtpVerification($otp,$contact_number);
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('user verify contact failure with contact '.$request->phone_number);
        return response()->$e;
    }  

        return response()->json(['success' => $success]);
    }

    
    public function sendOtpVerification($otp,$contact){
        $field = array(
            "sender_id" => "FSTSMS",
            "language" => "english",
            "route" => "qt",
            "numbers" => strval($contact),
            "message" => "26142",
            "variables" => "{#AA#}",
            "variables_values" => strval($otp)
            );
            
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_SSL_VERIFYHOST => 0,
              CURLOPT_SSL_VERIFYPEER => 0,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($field),
              CURLOPT_HTTPHEADER => array(
                "authorization: ".config("auth.sms_key"),
                "cache-control: no-cache",
                "accept: */*",
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
}
