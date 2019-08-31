<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExplorePagePost extends Model
{
    //
    
    public function getPosts(){
        $posts=SthubPost::getExplorePagePosts();
    }
    public function sthubPost()
    {
        return $this->belongsTo('App\Models\SthubPost');
    }
    public function scopeGetPostType($query,$type){
        $posts= $query->where('page_section',$type)->limit(3)->get();
        $data=[];
        foreach($posts as $post){
            $data[]=$post->sthubPost()->first();
        }
        return $data;
    }
}
