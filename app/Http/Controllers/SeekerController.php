<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SeekerController extends Controller
{
    //

    public function profile($profileId)
    {
        $user = \App\Models\User::where('users.id', $profileId)
            ->leftJoin('user_profiles as up', 'up.user_id', '=', 'users.id')
            ->select('up.*', 'users.id', 'users.full_name', 'users.email', 'users.avatar_url')
            ->first();
        return view('profile.profile')->with('user', $user);
    }
    public function educationDetail()
    {
        $course_levels = \App\Models\CourseLevel::get();
        $student = Auth::student();
        return view('user-onboarding.education-detail')
            ->with('student_details', $student)
            ->with('course_levels', $course_levels);
    }

    public function checkin()
    {
        $course_levels = \App\Models\CourseLevel::get();
        $student = Auth::student();
        return view('user-onboarding.checkin')
            ->with('student_details', $student)
            ->with('course_levels', $course_levels);
    }
    public function searchPage(Request $request)
    {
        return view('explore.search')->with('query', $request->query);
    }
    
}
