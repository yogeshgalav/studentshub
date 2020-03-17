<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    public function batch(){
        return $this->hasMany('App\Models\Batch');
    }
    public function totalBatch(){
        return $this->batch()->count();
    }
}
