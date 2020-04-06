<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExplorePagePost extends Model
{
    //
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
    public function scopeGetPostType($query,$type){
        $explore_posts= $query->where('page_section',$type)->limit(3)->get();
        $posts=[];
        foreach($explore_posts as $explore_post){
        $post=$explore_post->post;
         
        $post->image_path=$post->primary_image_path ?? '/images/blogpost.jpg';
        
        
        $post_content=$post->postable()->first();
        $rand=mt_rand(60,100);
        $content=$post_content->content ? substr($post_content->content,0,$rand): null;
        $post->content= $content;
        
        $post->heading=$post->post_heading;
        $post->user_name=$post->user_name;
        $post->subject_name=$post->subject->Subject_name;
        // $post->created_at=\Carbon\Carbon::createFromTimeStamp(strtotime($sthub_post->post->created_at))->diffForHumans();
        $post->total_views=$post->total_views;
        $post->total_likes=$post->total_likes;
        $post->total_dislikes=$post->total_dislikes;
        $posts[]=$post;
        }
        return $posts;
    }
}
