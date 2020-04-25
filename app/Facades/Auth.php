<?php

namespace App\Facades;

use Illuminate\Support\Facades\Auth as AuthUser;
use DB;

class Auth extends AuthUser
{
    public static function student(){
        if(!self::check()){
            return null;
        }
        
        return DB::table('students as st')->where('st.user_id','=',self::user()->id)
        ->leftJoin('batches as pbt','pbt.id','=','st.prefferred_batch')
        ->leftJoin('institutes as inst','inst.id','=','pbt.institute_id')
        ->leftJoin('courses','courses.id','=','pbt.course_id')
        ->select('inst.id as instituteId','courses.id as courseId','pbt.id as batchId')->first();
    }
}
