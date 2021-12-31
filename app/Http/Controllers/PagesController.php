<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Auth;
use App\Models\CourseLevel;
use App\Models\Student;

class PagesController extends Controller
{
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

    public function editPost()
    {
        return view('student.edit-post');
    }
    public function coursePage()
    {
        return view('guest.course');
    }
    public function subjectPage()
    {
        return view('guest.subject');
    }
    public function categoryPage()
    {
        return view('guest.category');
    }

    public function checkin()
    {
        $course_levels = CourseLevel::get();
        $student = Auth::student();
        return view('user-onboarding.checkin')
            ->with('student_details', $student)
            ->with('course_levels', $course_levels);
    }
    public function educationDetail()
    {
        $course_levels = CourseLevel::get();
        $student = Auth::student();
        return view('user-onboarding.education-detail')
            ->with('student_details', $student)
            ->with('course_levels', $course_levels);
    }

    public function classroomList()
    {
        return view('student.classroomList');
    }

    public function classroom()
    {
        return view('student.classroom');
    }
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
    public function sharePost(Request $request)
    {
        if($request->cId){
            $courseInfo = \App\Models\Course::find($request->cId);
        }
        if($request->sId){
            $subjectInfo = \App\Models\Subject::find($request->sId);
        }
        return view('create-post.share-post')
        ->with([
            'courseInfo' => isset($courseInfo) ? $courseInfo : null,
            'subjectInfo' => isset($subjectInfo) ? $subjectInfo : null,
        ]);
    }
    public function viewPost()
    {
        if (Auth::check()) {
            return view('seeker.post-view');
        }
        return view('guest.post-view');
    }
    public function report()
    {
        $total_users = \App\Models\User::count();
        $total_guests = \App\Models\Guest::count();
        $total_posts = \App\Models\Post::count();
        return view('admin.report')
            ->with('total_users', $total_users)
            ->with('total_guests', $total_guests)
            ->with('total_posts', $total_posts);
    }

    public function privacyPolicy(){
        return view('guest.privacy-policy');
    }
    public function termOfUse(){
        return view('guest.term-of-use');
    }

    public function Institute($instituteId = null)
    {
        $institute = \App\Models\InstituteUser::where('user_id',Auth::id())->first();
        
        return view('institute.institute')
        ->with('instituteId',$instituteId ?? $institute->institute_id);
    }
    public function seeker()
    {
        $user = Auth::user();
        if($user && empty($user->onboarded_at)){
            $user->role_intended = 'seeker';
            $user->onboarded_at = \Carbon\Carbon::now()->toDateTimeString();
            $user->save();
        }

        return redirect('/');
    }

    //     {
    //         var list= document.getElementsByClassName("index")[0].getElementsByTagName("A");
    // var newList=[];
    // for(let item of list){
    //     newList.push(item.innerText);
    // }
    // console.log(newList);
    //     }

}
