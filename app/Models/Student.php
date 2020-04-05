<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getPrefferredBranchAttribute(){
        return Batch::where('id',$this->prefferred_batch)->first()->branch_id;
    }

    public function batches(){
        return $this->belongsToMany('App\Models\Batch','batch_students','batch_id');
    }

    public function institutes(){
        return $this->belongsToMany('App\Models\Institute','batches','institute_id')->select('name');
    }

    public function courses(){
        return $this->belongsToMany('App\Models\Course','batches','course_id')->select('course_name');
    }

    public function branches(){
        return $this->belongsToMany('App\Models\Branch','batches','branch_id')->select('branch_name');
    }
}
