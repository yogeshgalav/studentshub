<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Faq;

class GuestController extends Controller
{
    //
    private $title = " | Student's Hub";

    public function loginPage()
    {
        if(Auth::check()){
            return redirect('/');
        }
        return view('guest.auth.login')
        ->with('emailError', session('emailError'))
        ->with('title','Login' . $this->title);
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
        if(Auth::check()){
            return redirect('/');
        }
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
    public function viewPost($post_id)
    {
        \App\Models\Post::findOrFail($post_id);
        if (Auth::check()) {
            return view('seeker.post-view');
        }
        return view('guest.post-view');
    }
    public function coursePage($course_url)
    {
        $course = \App\Models\Course::where('course_url', $course_url)->findOrFail();
        return view('explore.course')->with('courseId',$course->id);
    }
    public function subjectPage($subject_url)
    {
        $subject = \App\Models\Subject::where('subject_url', $subject_url)->findOrFail();
        return view('explore.subject')->with('subjectId',$subject->id);
    }
    public function categoryPage($category_url)
    {
        $category = \App\Models\Category::where('category_url', $category_url)->findOrFail();
        return view('explore.category')->with('categoryId',$category->id);
    }
    public function postImage($filename)
    {
        $path = storage_path('/app/post-images/' . $filename);

        if (!\File::exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
    
    public function  root()
    {
        $me = Auth::user();
        if ($me) {
            return view('seeker.posts');
        }
        return view('guest.welcome');
    }

    public function resetPassword(Request $request){
        $token = $request->token;
        return view('guest.auth.reset-password')
        ->with('token',$token);
    }

    public function searchPage(Request $request)
    {
        return view('explore.search')
        ->with('searchQuery', $request->qu);
    }
    public function FindInterestField(Request $request)
    {
        return view('create-post.find-interest-field');
    }
}
