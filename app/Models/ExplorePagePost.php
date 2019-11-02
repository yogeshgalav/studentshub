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
        $post_content=$sthub_post->post->postContent()->first();
        $primary_image=$sthub_post->post->image->where('is_primary',true)->first(); 
        $post->image_path=$primary_image ? $primary_image->path : '/images/blogpost.jpg';
        $rand=mt_rand(60,100);
        $content=$post_content? substr($post_content->content,0,$rand): null;
        $post->content= $content;
        $post->heading=$sthub_post->post->post_heading;
        $post->id=$sthub_post->post->id;
        $post->user_name=$sthub_post->post->user_name;
        $post->subject_name=$sthub_post->post->subject->Subject_name;
        $post->created_at=$sthub_post->post->created_at;
        // $post->created_at=\Carbon\Carbon::createFromTimeStamp(strtotime($sthub_post->post->created_at))->diffForHumans();
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
