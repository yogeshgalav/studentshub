<?php

namespace App\Traits;

use App\Models\Classroom;
use App\Models\ClassroomUser;
use App\Models\InstituteUser;
use App\Models\Student;

trait UserAccessTrait {


    public function joinedClassroomCount(){
        return \DB::table('classroom_users')
            ->where('user_id',$this->id)
            ->count();
    }

    public function createdClassroomCount(){
        return \DB::table('classrooms')
        ->where('classrooms.teacher_user_id',$this->id)
        ->count();
    }
    public function hasClassroom(){
        return $this->joinedClassroomCount()>0 || $this->createdClassroomCount()>0;
    }
    public function joinClassroom(Classroom $classroom)
    {
        $student = Student::firstOrCreate([
            'user_id' => $this->id,
            'institute_id' => $classroom->institute_id,
            'course_id' => $classroom->course_id
        ], [
            'is_preferred' => 1,
            // 'unique_college_id' => $request->college_id ?? null,
        ]);


        $this->role = 'student';
        $this->preferred_institute_id = $this->preferred_institute_id ?? $classroom->institute_id;
        $this->onboarded_at = $this->onboarded_at ?? \Carbon\Carbon::now()->toDateTimeString();
        $this->save();
        
        ClassroomUser::firstOrCreate([
            'classroom_id'=>$classroom->id,
            'user_id'=>$this->id,
        ]);
       // $batch_users = $batch->users()->whereNotIn('id', [$user->id]);
        // Notification::send($batch_users, new BatchNewUserNotification($user,$batch));
        // Notification::send($user, new StudentOnboardingNotification(count($batch_users)));
        return true;
    }

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