<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PagesController extends Controller
{
    public function  root(){
        if(Auth::check()){
            return view('home.dashboard');
        }else{
            return view('guest.welcome');
        }
    }

    public function dashboard(){
        return view('home.dashboard');
    }
    public function SthubPost(){
        return view('post.view-post');
    }
    public function createPost(){
        return view('post.create-post');
    }
    public function editPost(){
        return view('post.edit-post');
    }

    public function explore(){
        return view('explore');
    }

    public function profile(){
        return view('profile');
    }

    public function checkin(){
        return view('user.checkin');
    }

    public function classroomList(){
        return view('classroomList');
    }

    public function classroom(){
        return view('classroom');
    }
    public function loginPage(){
        return view('auth.login');
    }
    public function sharePost(){
        return view('post.share-post');
    }
}
