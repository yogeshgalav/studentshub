<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PagesController extends Controller
{
    public $AuthUserType='guest';
    public function __construct()
    {
        $AuthUser=Auth::user();
            if($AuthUser==null){
                $this->AuthUserType='guest';   
            }else if($AuthUser->student()->count()>0){
                $this->AuthUserType='student';   
            }else{
                $this->AuthUserType='seeker';   
            }
    }
    public function  root(){
        if(Auth::check()){
            return view($this->AuthUserType.'.home');
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
        return view('seeker.checkin');
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
}
