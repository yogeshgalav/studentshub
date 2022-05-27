<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Faq;
use App\Models\Category;
use App\Models\User;

class GuestController extends Controller
{
    //
    private $title = " | Student's Hub";

    public function membershipPlan()
    {
        return inertia('guest/membership-plan', [
            'Membership' . $this->title,
        ]);
    }
    public function forgotPasswordPage()
    {
        return inertia('auth/forgot-password');
    }

    public function feedbackPage()
    {
        return inertia('guest/feedback');
    }
    public function contactusPage(){
        return inertia('guest/contactus');
    }
    public function faqPage(){
        $faq = Faq::where('answer','!=', null)->get();
        return inertia('guest/faq', [
            'faqs' => $faq
        ]);
    }

    public function privacyPolicy(){
        return inertia('guest/privacy-policy');
    }
    public function termOfUse(){
        return inertia('guest/term-of-use');
    }
    public function viewPost($post_id)
    {
        $post = \App\Models\Post::findOrFail($post_id);
        if (Auth::check()) {
            return inertia('post/PostViewPage',[
                'post'=>$post
            ]);
        }
        return inertia('guest/guest-post-view',[
            'post'=>$post
        ]);
    }
    public function coursePage($course_url)
    {
        $course = \App\Models\Course::where('slug', $course_url)->firstOrFail();
        return inertia('explore/course', [
            'course' => $course
        ]);
    }
    public function subjectPage($subject_url)
    {
        $subject = \App\Models\Subject::where('slug', $subject_url)->firstOrFail();
        return inertia('explore/subject', [
            'subjectName' => $subject->subject_name,
            'subjectId' => $subject->id
        ]);
    }
    public function categoryPage($slug)
    {
        $category = \App\Models\Category::where('slug', $slug)->firstOrFail();
        return inertia('explore/category', [
            'categoryId' => $category->id
        ]);
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
            return inertia('common/dashboard');
        }
        return inertia('guest/welcome');
    }

    public function resetPassword(Request $request){
        $token = $request->token;
        return inertia('auth/reset-password', [
            'token' => $token
        ]);
    }

    public function searchPage(Request $request)
    {
        return inertia('common/search',[
            'searchQuery' => $request->qu
        ]);
    }
    public function FindInterestField(Request $request)
    {
        return inertia('create-post/find-interest-field');
    }
}
