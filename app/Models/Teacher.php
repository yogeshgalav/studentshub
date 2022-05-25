<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function institute(){
        return $this->belongsTo('App\Models\Institute','institute_id');
    }

    public function course(){
        return $this->belongsTo('App\Models\Course','course_id');
    }
}