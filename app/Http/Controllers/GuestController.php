<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class GuestController extends Controller
{
    //
    private $title = " | Student's Hub";

    public function loginPage()
    {
        return view('guest.auth.login')->with('title','Login' . $this->title);
    }
    public function membershipPlan()
    {
        return view('guest.membership-plan')->with('title','Membership' . $this->title);
    }
    public function forgotPasswordPage()
    {
        return view('guest.auth.forgot-password')->with('title','Fogot Password' . $this->title);
    }
    public function registerPage()
    {
        return view('guest.auth.register')->with('title','Get Started' . $this->title);
    }

    public function feedbackPage()
    {
        return view('guest.feedback')->with('title','Feedback' . $this->title);
    }
    public function contactusPage(){
        return view('guest.contactus')->with('title','Contact' . $this->title);
    }
    public function faqPage(){
        $faq = Faq::where('answer','!=', null)->get();
        return view('guest.faq')->with('faqs',$faq)->with('title','FAQ' . $this->title);
    }

    public function privacyPolicy(){
        return view('guest.privacy-policy')->with('title','Privacy Policy' . $this->title);
    }
    public function termOfUse(){
        return view('guest.term-of-use')->with('title','Term of Use' . $this->title);
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
