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
                $this->notifications=$AuthUser->notifications()->get()->each(function($notification){
                    $notification->text=NotificationText::where('notification_type',$notification->type)->first()->notification_text;
                });
                $this->AuthUserType='seeker';   
            }
    }

    public function postImage( $filename){
        $path = storage_path('app/post-images/' . $filename);

        if (!\File::exists($path)) {
            abort(404);
        }

        $file = \File::get($path);
        $type = \File::mimeType($path);

        $response = \Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function profileImage( $filename){
        $path = storage_path('app/uploads/profile/' . $filename);

        if (!\File::exists($path)) {
            abort(404);
        }

        $file = \File::get($path);
        $type = \File::mimeType($path);

        $response = \Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
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
    public function editPost(){
        return view('student.edit-post');
    }

    public function searchPage(){
        return view('guest.explore');
    }

    public function profile(){
        return view('student.profile');
    }

    public function checkin(){
        return view('student-register.student-register');
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
        return view('student.ask-question')->with('notifications',$this->notifications);
    }
    public function sharePost(){
        return view('create-post.share-post')->with('notifications',$this->notifications);
    }
    public function viewPost(){
        return view($this->AuthUserType.'.view-post')->with('notifications',$this->notifications);
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
    
//     {
//         var list= document.getElementsByClassName("index")[0].getElementsByTagName("A");
// var newList=[];
// for(let item of list){
//     newList.push(item.innerText);
// }
// console.log(newList);
//     }

}
