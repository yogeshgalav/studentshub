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
use Auth;
use App\Models\Feedback;
use App\Models\Contactus;

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
        $member->total_students = $request->students;
        $member->save();
        Log::critical('New member request with details.',['member'=>$member]);
        return response()->json([],204);
    }
    public function feedback(Request $request){
        Feedback::create([
            'email'=>$request->email,
            'user_id'=>Auth::id() ?? null,
            'description'=>$request->feedback,
        ]);
        return response()->json([],204);
    }
    public function feedbackPage(){
        return view('guest.feedback');
    }
    public function contactus(Request $request){
        Contactus::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'description'=>$request->description,
        ]);
        return response()->json([],204);
    }
    public function contactusPage(){
        return view('guest.contactus');
    }
    public function faq(){
        return view('guest.faq');
    }
    public function faqPage(){
        return view('guest.faq');
    }
}
