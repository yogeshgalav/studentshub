<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

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
