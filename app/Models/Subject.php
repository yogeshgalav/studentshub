<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    public function scopeGetAllCategories($query){
        return $query->where('parent_subject_id',0)->get();
    }
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
}
