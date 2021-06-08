<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\User;
use App\Models\ClassroomUser;
use App\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassroomPolicy
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
        if(ClassroomUser::where('user_id',$user->id)->where('classroom_id',$classroom->id)->exists()){
            return true;
        }
        if(Auth::teacher() && $classroom->teacher_user_id===Auth::teacher()->id){
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
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if(Auth::teacher()){
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
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Classroom  $classroom
     * @return mixed
     */
    public function update(User $user, Classroom $classroom)
    {
        if(Auth::teacher() && $classroom->teacher_user_id===Auth::teacher()->id){
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
        if(Auth::teacher() && $classroom->teacher_user_id===Auth::teacher()->id){
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
