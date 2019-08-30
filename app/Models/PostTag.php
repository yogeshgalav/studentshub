<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    //
    public function tag(){
        return $this->belongsTo('App\Models\Tag');
    }
    public function post(){
        return $this->belongsTo('App\Models\Post');
    }
} 
