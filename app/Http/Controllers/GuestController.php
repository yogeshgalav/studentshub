<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Subscriber;
use App\Models\MemberRequest;
use App\Mails\SubscriptionFirstMail;
use Mail;
use DB;
use Illuminate\Support\Facades\Log;

class GuestController extends Controller
{
    //
    public function update(Request $request)
    {
        $email=$request->input('email');
        DB::beginTransaction();
    try{
        $guest=Guest::where('ip',$request->ip())->first();
        $subcriber=new Subscriber;
        $subcriber->email=$email;
        $subcriber->guest_id=$guest_id;
        $subcriber->save();

        Mail::to($email)->send(new SubscriptionFirstMail());
        DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('user subscription failure: for email id#'.$email);
            // dd($e->getMessage(),$e->getLine());
            return response()->$e;
        }
        return 'success';
    }

    public function memberRequest(Request $request){
        $member =new MemberRequest;
        $member->full_name = $request->full_name;
        $member->email = $request->email;
        $member->phone_no = $request->phone_no;
        $member->institute_name = $request->institute_name;
        $member->plan = $request->plan;
        $member->save();
        Log::critical('New member request with details.',['member'=>$member]);
        return response()->json([],204);
    }
}
