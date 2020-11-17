<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function users(){
        $users=[];
        foreach($this->students()->get() as $student){
            $users[]=$student->user()->first();
        }
        return collect($users);
    }
    public function students(){
        return $this->belongsToMany('App\Models\Student','batch_students','batch_id','student_id');
    }
    public function institute(){
        return $this->belongsTo('App\Models\Institute','institute_id');
    }

    public function course(){
        return $this->belongsTo('App\Models\Course','course_id');
    }

    public function branch(){
        return $this->belongsTo('App\Models\Branch','branch_id');
    }
}
