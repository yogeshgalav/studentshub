<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SthubPost extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    protected $with=['post'];
    public function post()
    {
        return $this->belongsTo('App\Models\Post')->with(['postContent','subject','tags']);
    }
    public function scopeGetExplorePagePosts($query){
        return $query->where('post_type','article')->get();
    }
}
