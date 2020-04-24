<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function scopeGetAllCategories($query){
        return $query->where('parent_subject_id',0)->get();
    }
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
    
    public function courses(){
        return $this->belongsToMany('App\Models\Course','course_subjects');
    }
}
