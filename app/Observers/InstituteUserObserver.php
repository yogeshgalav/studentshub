<?php

namespace App\Observers;

class InstituteUserObserver
{
    //
    public function Creating(InstituteUser $in_user){
        if(!InstituteUser::where(['institute_id'=>$in_user->institute_id])->exists()){
            $in_user->role='admin';
        }
        return $in_user;
    }
}
