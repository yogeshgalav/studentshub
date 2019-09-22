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
    public function scopeGetDashboardPosts($query){
        return $query->where('college_id',Auth::user()->college_id)
        // ->orWhere('classroom_id',Auth::user()->classroom_id)
        // ->orWhere('branch_id	',Auth::user()->branch_id	)
        // ->orWhere('course_id',Auth::user()->course_id)
        // ->orWhere('batch_id',Auth::user()->batch_id)
        ->get()->each(function($sthub_post){
            $post=$sthub_post->post;
            $sthub_post->content=$post->shortContent();
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
