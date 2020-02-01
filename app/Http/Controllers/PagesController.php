<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\NotificationText;

class PagesController extends Controller
{
    public $AuthUserType='guest';
    public $notifications;
    public function __construct()
    {
        $AuthUser=Auth::user();
            if($AuthUser==null){
                $this->AuthUserType='guest';   
            }else if($AuthUser->student()->count()>0){
                $this->AuthUserType='student';
                $this->notifications=$AuthUser->notifications()->get()->each(function($notification){
                    $notification->text=NotificationText::where('notification_type',$notification->type)->first()->notification_text;
                });   
            }else{
                $this->AuthUserType='seeker';   
            }
    }
    public function  root(){
        if(Auth::check()){
            return view($this->AuthUserType.'.home')->with('notifications',$this->notifications);
        }else{
            return view('guest.welcome');
        }
    }

    public function dashboard(){
        return view($this->AuthUserType.'.home');
    }
    public function createPost(){
        return view('student.create-post');
    }
    public function editPost(){
        return view('student.edit-post');
    }

    public function explore(){
        return view('guest.explore');
    }

    public function profile(){
        return view('student.profile');
    }

    public function checkin(){
        $courses=\App\Models\Course::with('category')->get();
        $branches=\App\Models\Branch::all();
        return view('student-register.student-register')->with('branches',$branches)->with('courses',$courses);
    }

    public function classroomList(){
        return view('student.classroomList');
    }

    public function classroom(){
        return view('student.classroom');
    }
    public function loginPage(){
        return view('guest.auth.login');
    }
    public function forgotPasswordPage(){
        return view('guest.auth.forgot-password');
    }
    public function registerPage(){
        return view('guest.auth.register');
    }
    public function askQuestion(){
        return view('student.ask-question');
    }
    public function sharePost(){
        return view('student.share-post');
    }
    public function viewPost(){
        return view($this->AuthUserType.'.view-post');
    }
    public function report(){
        $total_users=\App\Models\User::count();
        $total_guests=\App\Models\Guest::count();
        $total_posts=\App\Models\Post::count();
        return view('admin.report')
        ->with('total_users',$total_users)
        ->with('total_guests',$total_guests)
        ->with('total_posts',$total_posts)
        ;
    }
    // public function test(){
    //     $courses=\App\Models\Course::all();
    //     foreach($courses as $course){
    //         if(!is_null($course->category_id)){
    //             continue;
    //         }
    //         if (preg_match('/ of (.*?) \(/', $course->course_name, $match) == 1) {
    //             $course_type=\App\Models\Category::create(['name'=>$match[1]]);
                // $course->category_id=$course_type->id;
    //             $course->save();
    //             echo $course->id.' '.$match[1].'<br/>';
    //         }else if (preg_match('/ in (.*?) \(/', $course->course_name, $match) == 1) {
    //             $course_type=\App\Models\Category::create(['name'=>$match[1]]);
    //             $course->category_id=$course_type->id;
    //             $course->save();
    //             echo $course->id.' '.$match[1].'<br/>';
    //         }else{
    //             $course_type=\App\Models\Category::create(['name'=>$course->course_name]);
    //             $course->category_id=$course_type->id;
    //             $course->save();
    //             echo 'fuck'.$course->id.' '.$course->course_name.'<br/>';
    //         }
    //     }
    // }

}
