<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SeekerController extends Controller
{
    //
    // public function seekerCheckin(){
    //     $user = Auth::user();
    //     $user->role_intended = 'seeker';
    //     $user->onboarded_at = \Carbon\Carbon::now()->toDateTimeString();
    //     $user->save();

    //     return redirect('/');
    // }
    public function profile($profileId)
    {
        $user = \App\Models\User::where('users.id', $profileId)
            ->leftJoin('user_profiles as up', 'up.user_id', '=', 'users.id')
            ->leftJoin('institutes as in', 'in.id', '=', 'users.preferred_institute_id')
            ->leftJoin('courses as co', 'co.id', '=', 'users.preferred_course_id')
            ->select('up.*', 'users.id', 'users.full_name', 'users.email', 'users.avatar_url',
            'in.name as preferred_institute_name', 'co.course_name as preferred_course_name')
            ->first();
            
        return inertia('profile/profile', [
            'user'=> $user
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
    public function accountSetting()
    {
        $user = \App\Models\User::where("id",Auth::id())
        ->with(['profile','preferredCourse','preferredInstitute'])
        ->first();
        return inertia('profile/account-setting', [
            'user'=> $user
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

    public function doubtAnswersPage(){
        return inertia('doubt/show');
    }
}