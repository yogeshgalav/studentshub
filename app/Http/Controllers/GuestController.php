<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Mails\SubscriptionFirstMail;
use Mail;

class GuestController extends Controller
{
    //
    public function update(Request $request)
    {
        $guest=Guest::where('ip',$request->ip())->first();
        $guest->email=$request->input('email');
        $guest->is_subscribed=true;
        $guest->save();

        Mail::to($request->input('email'))->send(new SubscriptionFirstMail());
    }
}
