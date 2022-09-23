<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function post(){
        return $this->hasMany('App\Models\Post');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function course(){
        return $this->belongsTo('App\Models\Course');
    }

    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }

    public function institute(){
        return $this->belongsTo('App\Models\Institute');
    }

    public function classroomFollower(){
        return $this->hasMany(ClassroomFollower::class, 'classroom_id');
    }


}
