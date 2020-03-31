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
        ->leftJoin('branches as brnch','brnch.id','=','pbt.branch_id')
        ->select('inst.id as instituteId','brnch.id as branchId')->first();
    }
}
