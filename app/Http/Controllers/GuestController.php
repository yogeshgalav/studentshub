<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Mails\SubscriptionFirstMail;
use Mail;
use Log;

class GuestController extends Controller
{
    //
    public function update(Request $request)
    {
        $email=$request->input('email');
        DB::beginTransaction();
    try{
        $guest=Guest::where('ip',$request->ip())->first();
        $guest->email=$email;
        $guest->is_subscribed=true;
        $guest->save();

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
    public function checkinApi(){
        $courses=\App\Models\Course::with('category')->get();
        $branches=\App\Models\Branch::all();
        return response()->json(['success'=>[
            'courses'=>$courses,
            'branches'=>$branches
        ]]);
    }
}
