<?php

namespace App\Models;

use App\Traits\UserAccessTrait;
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
    use UserAccessTrait;
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
        'last_login_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    use HasSlug;


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('full_name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnCreate();
    }

    public function student()
    {
        return $this->hasMany('App\Models\Student');
    }

    public function parents()
    {
        return $this->hasMany(UserParent::class, 'user_id');
    }

    public function post()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function lead(){
        return $this->hasOne('App\Models\Lead');
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
        $full_name=preg_split('/\s+/', $this->full_name, NULL, PREG_SPLIT_NO_EMPTY);
        return implode(" ", array_slice($full_name, 0, -1));
    }
    public function getLastNameAttribute(){
        $full_name=preg_split('/\s+/', $this->full_name, NULL, PREG_SPLIT_NO_EMPTY);
        return end($full_name);
    }

    public function setFullNameAttribute($value){
        $this->attributes['full_name'] = ucwords($value);
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
        $role= $this->role;
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
        } elseif ('sthub_staff'===$role) {
            $classroom_query=$classroom_query;
        } else {
            return [];
        }

        return $classroom_query->groupBy('classrooms.id')->pluck('classrooms.id')->toArray();
    }
    
    public function preferredInstitute()
    {
        return $this->belongsTo(Institute::class, 'preferred_institute_id');
    }
    public function preferredCourse()
    {
        return $this->belongsTo(Course::class, 'preferred_course_id');
    }
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function getStudentIds(){
        return [];   
    }

    public function canCreateClassroom()
    {
        if(in_array($this->role,['seeker','student'])){
            return false;
        }
        return true;
    }
    public function isStaff(){
        return $this->role==='sthub_staff';
    }
}
