<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    //

    public function feedbackPage(){
        return view('guest.feedback');
    }
    public function contactusPage(){
        return view('guest.contactus');
    }
    public function faqPage(){
        return view('guest.faq');
    }
}
