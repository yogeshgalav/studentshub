<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class SthubPost extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    protected $with=['post'];
    public function post()
    {
        return $this->belongsTo('App\Models\Post')->with(['postable','subject','tags']);
    }
    //get post for seeker or student dashboard page
    public function scopeGetDashboardPosts($query){

        $dashboard_posts=$query->where('institute_id',Auth::user()->institute_id)
        // ->orWhere('classroom_id',Auth::user()->classroom_id)
        // ->orWhere('course_id',Auth::user()->course_id)
        // ->orWhere('batch_id',Auth::user()->batch_id)
        ->orderBy('id', 'DESC')->get();

        $posts=[];
        foreach($dashboard_posts as $dashboard_post){
        $post=$dashboard_post->post;
         
        $post->image_path=$post->primary_image_path ?? '/images/blogpost.jpg';
        
        
        $post_content=$post->postable()->first();
        $rand=mt_rand(60,100);
        $content=$post_content->content ? substr($post_content->content,0,$rand): null;
        $post->content= $content;
        
        $post->user_name=$post->user_name;
        $post->subject_name=$post->subject->Subject_name;
        // $post->created_at=\Carbon\Carbon::createFromTimeStamp(strtotime($sthub_post->post->created_at))->diffForHumans();
        $post->total_views=$post->total_views;
        $post->total_likes=$post->total_likes;
        $posts[]=$post;
        }
        
        return $posts;
    }
}
