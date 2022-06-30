<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Institute;
use App\Models\InstituteUser;
use Auth;

class InstituteController extends Controller
{
    //

    public function myInstitute()
    {   $me=Auth::id();

        $instituteId = Auth::user()->preferred_institute_id;
        $editPermission=InstituteUser::where('user_id','=',$me)
        ->where('role','=','instituteAdmin')
        ->exists();
        
        $instituteVerified=Institute::where('is_verified','=',1)
        ->where('id','=',$instituteId)
        ->exists();

        return inertia('common/my-institute', ['editPermission' => $editPermission, 'instituteVerified'=>$instituteVerified]);
    }
    public function Institute($instituteId = null)
    {
        $institute = \App\Models\InstituteUser::where('user_id',Auth::id())->first();
        
        return view('institute.institute')
        ->with('instituteId',$instituteId ?? $institute->institute_id);
    }
    public function indexStudents()
    {
        return view('institute.index-student');
    }
    public function showStudent()
    {
        return view('institute.show-student');
    }
}
