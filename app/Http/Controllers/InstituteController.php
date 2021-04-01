<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class InstituteController extends Controller
{
    //

    public function Institute($instituteId = null)
    {
        $institute = \App\Models\InstituteUser::where('user_id',Auth::id())->first();
        
        return view('institute.institute')
        ->with('instituteId',$instituteId ?? $institute->institute_id);
    }
}
