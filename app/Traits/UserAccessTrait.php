<?php

namespace App\Traits;

use App\Models\Classroom;
use App\Models\ClassroomUser;
use App\Models\InstituteUser;

trait UserAccessTrait {

    public function hasClassroomAccess(Classroom $classroom)
    {
        return $this->canAccessClassroomAsStudent($classroom) || $this->canAccessClassroomAsTeacher($classroom);
    }

    public function canAccessClassroomAsStudent(Classroom $classroom)
    {
        if(ClassroomUser::where('user_id',$this->id)
            ->where('classroom_id',$classroom->id)->exists()){
            return true;
        }
        return false;
    }
    public function canAccessClassroomAsTeacher(Classroom $classroom)
    {
        if(InstituteUser::where('user_id',$this->id)
        ->where('institute_id',$classroom->institute_id)->exists()){
            return true;
        }
        return false;
    }
    public function hasInstituteUserAccess()
    {
        if(InstituteUser::where('user_id',$this->id)
        ->where('institute_id',$this->preferred_institute_id)
        // ->where('is_verified',1)
        ->exists()){
            return true;
        }
        return false;
    }
}

?>