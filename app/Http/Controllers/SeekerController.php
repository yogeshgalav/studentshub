<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doubt;
use Auth;
use DB;

class SeekerController extends Controller
{
    //
    // public function seekerCheckin(){
    //     $user = Auth::user();
    //     $user->role = 'seeker';
    //     $user->onboarded_at = \Carbon\Carbon::now()->toDateTimeString();
    //     $user->save();

    //     return redirect('/');
    // }
    public function profile($profileId, Request $request)
    {   
        $me_id = Auth::user()->id;
        $user = \App\Models\User::where('users.id', $profileId)
            ->leftJoin('user_profiles as up', 'up.user_id', '=', 'users.id')
            ->leftJoin('institutes as in', 'in.id', '=', 'users.preferred_institute_id')
            ->leftJoin('courses as co', 'co.id', '=', 'users.preferred_course_id')
            ->select('up.*', 'users.id', 'users.full_name', 'users.email', 'users.avatar_url',
            'in.name as preferred_institute_name', 'co.course_name as preferred_course_name')
            ->first();

        $follower = \App\Models\User::where('users.id', $profileId)
            ->leftJoin('follows as my_follow',function($join)use($me_id){
                $join->on('users.id','=','my_follow.following_id')->where('my_follow.followed_by_id','=',$me_id);
              })
            ->leftJoin('follows as total_followers',function($join){
                  $join->on('users.id','=','total_followers.following_id')->where('total_followers.follow_status','=',1);
              })
            ->select(DB::raw('COUNT(DISTINCT total_followers.id) as total_followers'), 'my_follow.follow_status as myfollow')
            ->groupBy('my_follow.follow_status') 
            ->first();

            $follows=DB::table('follows as followers')
            ->leftjoin('users as us', 'followers.followed_by_id','=','us.id')->where('followers.following_id','=',$profileId)
            ->select('followers.followed_by_id','us.full_name','followers.following_id')->get();
            
            $followings=DB::table('follows as following')
            ->leftjoin('users as us', 'following.following_id','=','us.id')->where('following.followed_by_id','=',$profileId)
            ->select('following.followed_by_id','us.full_name','following.following_id')->get();
            
        return inertia('profile/profile', [
            'user'=> $user,
            'follower'=>$follower,
            'follows'=>$follows,
            'followings'=>$followings
        ]);
    }
    // public function educationDetail()
    // {
    //     $course_levels = \App\Models\CourseLevel::get();
    //     $student = Auth::student();
    //     return view('user-onboarding.education-detail')
    //         ->with('student_details', $student)
    //         ->with('classroom_count', Auth::user()->joinedClassroomCount())
    //         ->with('course_levels', $course_levels);
    // }
    public function accountSetting(Request $request)
    {
        $user = \App\Models\User::where("id",Auth::id())
        ->with(['profile','preferredCourse','preferredInstitute'])
        ->first();
        $teachers=DB::table('teachers as te')
        ->leftJoin('institutes as inst','inst.id','=','te.institute_id')
        ->leftJoin('courses as co','co.id','=','te.course_id')
        ->select(['te.id as teacher_id','institute_id','course_id', 'course_name', 'inst.name as institute_name'])
        ->get();
        $students=DB::table('students as st')
        ->leftJoin('institutes as inst','inst.id','=','st.institute_id')
        ->leftJoin('courses as co','co.id','=','st.course_id')
        ->select(['st.id as student_id','institute_id','course_id', 'course_name', 'inst.name as institute_name'])
        ->get();
        return inertia('profile/account-setting', [
            'user'=> $user,
            'teachers'=> $teachers,
            'students'=>$students
        ]);
    }
    // public function checkin()
    // {
    //     $course_levels = \App\Models\CourseLevel::get();
    //     $student = Auth::student();
    //     return view('user-onboarding.checkin')
    //         ->with('student_details', $student)
    //         ->with('course_levels', $course_levels);
    // }
    public function notifications(){
        return inertia('common/notifications');
    }
    public function category(){
        return inertia('profile/categories');
    }

    public function doubtPage()
    {
        $categories = \App\Models\Category::all();
        return inertia('doubt/index',[
            'categories'=>$categories
        ]);
    }

    public function doubtAnswersPage(Doubt $doubt){
      return inertia('doubt/show', ['doubts' =>$doubt]);
    }
}