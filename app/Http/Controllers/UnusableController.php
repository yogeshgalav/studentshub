<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnusableController extends Controller
{
    public function sharedData(){
        $me = Auth::user();
        if($me){
            $me = $me->leftJoin('students as st','st.user_id','=','users.id')
            ->leftJoin('teachers as tc','tc.user_id','=','users.id')
            ->leftJoin('institute_users as iu','iu.user_id','=','users.id')
            ->select(['users.id','users.full_name','users.role','users.avatar_url',
            DB::raw("COUNT('st.id') as is_student"),
            DB::raw("COUNT('tc.id') as is_teacher"),
            DB::raw("COUNT('iu.id') as is_admin"),
            ])
            ->groupBy(['users.id','users.full_name','users.role','users.avatar_url'])
            ->first();
        }
    }
}
