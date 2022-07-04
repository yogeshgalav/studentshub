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
    {   
        $me=Auth::user();
    
        $instituteId = $me->preferred_institute_id;
        $editPermission= false;
        $instituteVerified= false;
        $institute = null;

        if($instituteId){
            $editPermission=InstituteUser::where('user_id','=',$me->id)
            ->where('institute_id','=',$instituteId)
            // ->where('is_admin','=',1)
            ->exists();
            
            $institute = Institute::where('id','=',$instituteId)->first();
            $instituteVerified = (Bool)$institute->is_verified;
        }

        return inertia('institute/show-institute', [
            'institute'=> $institute,
            'editPermission' => $editPermission, 
            'instituteVerified'=>$instituteVerified
        ]);
    }
    public function show($instituteId)
    {   
        $me=Auth::user();

        $institute = Institute::where('id','=',$instituteId)->first();

        $editPermission= false;
        $instituteVerified = (Bool)$institute->is_verified;

        $editPermission=InstituteUser::where('user_id','=',$me->id)
        ->where('institute_id','=',$institute->id)
        // ->where('is_admin','=',1)
        ->exists();

        return inertia('institute/show-institute', [
            'institute'=> $institute,
            'editPermission' => $editPermission, 
            'instituteVerified'=>$instituteVerified
        ]);
    }
    public function show2($instituteId = null)
    {
        $institute = \App\Models\InstituteUser::where('user_id',Auth::id())->first();
        
        return view('institute.institute2')
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
