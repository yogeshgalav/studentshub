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
        return $this->belongsTo('App\Models\Post')->with(['postContent','subject','tags']);
    }
    //get post for seeker or student dashboard page
    public function scopeGetDashboardPosts($query){
        return $query->where('college_id',Auth::user()->college_id)
        // ->orWhere('classroom_id',Auth::user()->classroom_id)
        // ->orWhere('branch_id	',Auth::user()->branch_id	)
        // ->orWhere('course_id',Auth::user()->course_id)
        // ->orWhere('batch_id',Auth::user()->batch_id)
        ->orderBy('id', 'DESC')->get()->each(function($sthub_post){
            $post=$sthub_post->post;
            $sthub_post->id=$post->id;
            $rand=mt_rand(60,100);
            $content=$post_content? substr($post_content->content,0,$rand): null;
            $sthub_post->content= $content;
            $primary_image=$post->image->where('is_primary',true)->first(); 
            $sthub_post->image_path=$primary_image ? $primary_image->path : '/images/blogpost.jpg';
            $sthub_post->heading=$post->post_heading;
            $sthub_post->user_name=$post->user_name;
            $sthub_post->subject_name=$post->subject->Subject_name;
            $sthub_post->created_at=$post->created_at;
            // $sthub_post->created_at=\Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans();
            $sthub_post->total_views=$post->total_views;
            $sthub_post->total_likes=$post->total_likes;
            });
    }
}
