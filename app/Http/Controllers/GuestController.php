<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class GuestController extends Controller
{
    //

    public function loginPage()
    {
        return view('guest.auth.login');
    }
    public function membershipPlan()
    {
        return view('guest.membership-plan');
    }
    public function forgotPasswordPage()
    {
        return view('guest.auth.forgot-password');
    }
    public function registerPage()
    {
        return view('guest.auth.register');
    }
    public function feedbackPage(){
        return view('guest.feedback');
    }
    public function contactusPage(){
        return view('guest.contactus');
    }
    public function faqPage(){
        return view('guest.faq');
    }

    public function privacyPolicy(){
        return view('guest.privacy-policy');
    }
    public function termOfUse(){
        return view('guest.term-of-use');
    }
    public function viewPost()
    {
        if (Auth::check()) {
            return view('seeker.post-view');
        }
        return view('guest.post-view');
    }
    public function coursePage()
    {
        return view('explore.course');
    }
    public function subjectPage()
    {
        return view('explore.subject');
    }
    public function categoryPage()
    {
        return view('explore.category');
    }
    public function postImage($filename)
    {
        $path = storage_path('/app/post-images/' . $filename);

        if (!\File::exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function profileImage($filename)
    {
        $path = storage_path('app/profile-images/' . $filename);

        if (!\File::exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
    public function  root()
    {
        if (Auth::check()) {
            return view('seeker.posts');
        } else {
            return view('guest.welcome');
        }
    }
}
