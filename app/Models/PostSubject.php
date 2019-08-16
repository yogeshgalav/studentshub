<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostSubject extends Model
{
    //
    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }
    public function post(){
        return $this->belongsTo('App\Models\Post');
    }
}
