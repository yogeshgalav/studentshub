<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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

    public function student()
    {
        return $this->hasOne('App\Models\Student');
    }
    public function post()
    {
        return $this->hasMany('App\Models\Post');
    }
    public function teacher()
    {
        return $this->hasOne('App\Models\Teacher');
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

    public function joinedClassoomCount(){
        return \DB::table('classroom_users')
            ->where('user_id',$this->id)
            ->where('joined_at','!=',null)
            ->count();
    }

    public function isInstituteMember(){
        return \DB::table('institute_users')
            ->where('user_id',$this->id)
            ->exists();
    }
}
