<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use HasPushSubscriptions;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    use HasSlug;


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('full_name')
            ->saveSlugsTo('slug');
    }
    public function student()
    {
        return $this->hasOne('App\Models\Student');
    }
    public function post()
    {
        return $this->hasMany('App\Models\Post');
    }

    /***
     * Now many new/unread notifications are
     * waiting for this user?
     *
     * @return int
     * @since 3.0.0
     */
    public static function notificationCount()
    {
        return 0;
    }

    public function getFirstNameAttribute(){
        $full_name=$this->full_name;
        $parts = explode(" ", $full_name);
        if(count($parts) > 1) {
            $lastname = array_pop($parts);
            return implode(" ", $parts);
        }
        return $full_name;
    }

    public function setFullNameAttribute($value){
        $this->attributes['full_name'] = ucwords($value);
    }

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
    public function isInstituteMember(){
        return \DB::table('institute_users')
            ->where('user_id',$this->id)
            ->exists();
    }
    public function isAdmin(){
        return \DB::table('admins')
            ->where('user_id',$this->id)
            ->exists();
    }
    public function getClassroomIds(){
        $role= $this->role_intended;
        $classroom_query = \DB::table('classrooms');
        if ('student'===$role) {
            $classroom_query=$classroom_query->rightJoin('classroom_users as cu',function($join){
                $join->on('cu.classroom_id','=','classrooms.id')->where('cu.user_id','=',$this->id);
            });
        } elseif ('teacher'===$role || 'instituteAdmin'===$role) {
            $classroom_query=$classroom_query->rightJoin('users as usr',function($join){
                $join->on('usr.id','=','classrooms.teacher_user_id')->where('usr.id','=',$this->id);
            });
        // } elseif ('instituteAdmin'===$role) {
        //     $classroom_query=$classroom_query->rightJoin('institutes as ins','ins.id','=','classrooms.institute_id')
        //     ->rightJoin('institute_users as inu', function($join){
        //         $join->on('ins.id','=','inu.institute_id')->where('inu.user_id','=',$this->id);
        //     });
        } elseif ('sthubAdmin'===$role) {
            $classroom_query=$classroom_query;
        } else {
            $classroom_query=$classroom_query->where('0','=', '1');
        }

        return $classroom_query->groupBy('classrooms.id')->pluck('classrooms.id')->toArray();
    }
    public function preferredInstituteId()
    {
        if($student = Auth::student()){
            return $student->instituteId;
        }
        if($teacher = Auth::teacher()){
            return $teacher->instituteId;
        }
    }
    
    public function getStudentIds(){
        return [];   
    }
}
