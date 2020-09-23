<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Auth;
use App\Models\Batch;
use App\Models\CourseLevel;
use App\Models\NotificationText;
use App\Models\Student;

class PagesController extends Controller
{
    public $AuthUserType = 'guest';
    public function __construct()
    {
        $AuthUser = Auth::user();
        if ($AuthUser == null) {
            $this->AuthUserType = 'guest';
        } else if ($AuthUser->student()->count() > 0) {
            $this->AuthUserType = 'student';
        } else {
            $this->AuthUserType = 'seeker';
        }
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
            return view($this->AuthUserType . '.home');
        } else {
            return view('guest.welcome');
        }
    }

    public function editPost()
    {
        return view('student.edit-post');
    }

    public function searchPage(Request $request)
    {
        return view('explore.search')->with('query', $request->query);
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

    public function checkin()
    {
        $course_levels = CourseLevel::get();
        $student = Auth::student();
        return view('student-register.student-register')
            ->with('student_details', $student)
            ->with('course_levels', $course_levels);
    }

    public function profile($profileId)
    {
        $user = \App\Models\User::where('users.id', $profileId)
            ->leftJoin('user_profiles as up', 'up.user_id', '=', 'users.id')
            ->select('up.*', 'users.id', 'users.full_name', 'users.email', 'users.avatar_url')
            ->first();
        return view('profile.profile')->with('user', $user);
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
    public function forgotPasswordPage()
    {
        return view('guest.auth.forgot-password');
    }
    public function registerPage()
    {
        return view('guest.auth.register');
    }
    public function askQuestion()
    {
        return view('student.ask-question');
    }
    public function sharePost()
    {
        return view('create-post.share-post');
    }
    public function viewPost()
    {
        return view($this->AuthUserType . '.view-post');
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

    public function Institute()
    {
        $institute = \App\Models\InstituteUser::where('user_id',Auth::id())->first();
        return view('institute.institute')
        ->with('instituteId',$institute->institute_id);
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
