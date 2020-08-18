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
        ->join('batches as pbt','pbt.id','=','st.prefferred_batch')
        ->join('institutes as inst','inst.id','=','pbt.institute_id')
        ->join('courses','courses.id','=','pbt.course_id')
        ->leftJoin('categories as cat','cat.id','=','courses.category_id')
        ->select('inst.id as instituteId','inst.name as instituteName','courses.id as courseId','courses.course_name as courseName','pbt.id as batchId','cat.id as categoryId')->first();
    }

    public static function teacher(){
        if(!self::check()){
            return null;
        }
        
        return DB::table('teachers as th')->where('th.user_id','=',self::user()->id)
        ->leftJoin('institutes as inst','inst.id','=','th.institute_id')
        ->select('inst.id as instituteId','th.id as id','th.user_id')->first();
    }
}
