<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\User;
use App\Models\Institute;
use App\Models\InstituteUser;
use App\Models\Homework;
use App\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class HomeworkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classroom  $classroom
     * @return mixed
     */
    public function view(User $user, Classroom $classroom)
    {
        if($user->role_intended==='sthubAdmin'){
            return true;
        }
        $classroom_ids = $user->getClassroomIds();
        if(in_array($classroom->id,$classroom_ids)){
            return true;
        }
        return false;
    }
    public function markAsDone(User $user, Homework $homework)
    {
        $classroom_ids = $user->getClassroomIds();
        if(in_array($homework->classroom_id,$classroom_ids)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classroom  $classroom
     * @return mixed
     */
    public function update(User $user, Classroom $classroom)
    {
        if($user->role_intended==='sthubAdmin'){
            return true;
        }
        if($classroom->teacher_user_id===$user->id){
            return true;
        }
        // if($user->role==='instituteAdmin'){
        //     return true;
        // }
        // if($user->role==='superAdmin'){
        //     return true;
        // }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classroom  $classroom
     * @return mixed
     */
    public function delete(User $user, Classroom $classroom)
    {
        if($user->role_intended==='sthubAdmin'){
            return true;
        }
        if($classroom->teacher_user_id===$user->id){
            return true;
        }
        // if($user->role==='instituteAdmin'){
        //     return true;
        // }
        // if($user->role==='superAdmin'){
        //     return true;
        // }
        return false;
    }
}
