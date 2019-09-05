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
        $posts= $query->where('page_section',$type)->limit(3)->get()->each(function($post){
        $sthub_post=$post->sthubPost()->first();
        // $post->sthub_post=$sthub_post;
        $post->content=$sthub_post->post->shortContent();
        $post->heading=$sthub_post->post->post_heading;
        $post->user_name=$sthub_post->post->user_name;
        $post->subject_name=$sthub_post->post->subject->Subject_name;
        $post->created_at=$sthub_post->post->created_at;
        $post->total_views=$sthub_post->post->total_views;
        $post->total_likes=$sthub_post->post->total_likes;
        });
        // $data=[];
        // foreach($posts as $post){
        //     $data[]=$post->sthubPost()->first();
        // }
        // return $data;
        return $posts;
    }
}
