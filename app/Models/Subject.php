<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
    
    public function courses(){
        return $this->belongsToMany('App\Models\Course','course_subjects');
    }
    public function course_subjects(){
        return $this->hasMany('App\Models\CourseSubject');
    }

    public function setSubjectNameAttribute($value){
        return ucwords($value);
    }
}
