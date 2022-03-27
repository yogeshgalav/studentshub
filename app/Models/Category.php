<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected  $guarded = ['id', 'name', 'slug'];

    public function courses(){
        return $this->hasMany('App\Models\Course');
    }
    public function subjects(){
        return $this->hasMany('App\Models\Subject');
    }
}
