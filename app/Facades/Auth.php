<?php

namespace App\Facades;

use Illuminate\Support\Facades\Auth as AuthUser;
use DB;

class Auth extends AuthUser
{
    public static function student()
    {
        if (!self::check()) {
            return null;
        }
        if (self::user()->role_intended!=='student') {
            return null;
        }
        return DB::table('students as st')->where('st.user_id', '=', self::user()->id)
            //->join('batches as pbt', 'pbt.id', '=', 'st.prefferred_batch')
            ->where('st.is_preferred',1)
            ->join('institutes as inst', 'inst.id', '=', 'st.institute_id')
            ->join('courses', 'courses.id', '=', 'st.course_id')
            ->leftJoin('categories as cat', 'cat.id', '=', 'courses.category_id')
            ->select(
                'inst.id as instituteId',
                'inst.name as instituteName',
                'courses.id as courseId',
                'courses.course_name as courseName',
                'courses.course_url as courseUrl',
                'cat.id as categoryId',
                'st.unique_college_id as college_id'
            )->first();
    }

    public static function teacher()
    {
        if (!self::check()) {
            return null;
        }
        if (self::user()->role_intended!=='teacher') {
            return null;
        }
        return DB::table('institute_users as insu')->where('insu.user_id', '=', self::user()->id)
            ->where('insu.role','teacher')
            ->leftJoin('institutes as inst', 'inst.id', '=', 'insu.institute_id')
            ->select(
                'inst.id as instituteId',
                'inst.name as instituteName',
                'insu.id as id', 'insu.user_id'
            )->first();
    }
    public static function instituteAdmin()
    {
        if (!self::check()) {
            return null;
        }
        if (self::user()->role_intended!=='instituteAdmin') {
            return null;
        }
        return DB::table('institute_users as iu')
            ->where('iu.user_id', '=', self::user()->id)
            ->where('iu.role', '=', 'admin')
            ->leftJoin('institutes as inst', 'inst.id', '=', 'iu.institute_id')
            ->select(
                'inst.id as instituteId',
                'inst.name as instituteName',
            )->first();
    }
}
