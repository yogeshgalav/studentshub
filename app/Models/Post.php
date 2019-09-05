<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $appends=['user_name','total_views','total_likes'];
    public function article(){
        return $this->hasOne('App\Models\Article');
    }
    public function notice(){
        return $this->hasOne('App\Models\Notice');
    }
    public function document(){
        return $this->hasOne('App\Models\Document');
    }
    public function fact(){
        return $this->hasOne('App\Models\Fact');
    }
    public function MCQ(){
        return $this->hasOne('App\Models\MultipleChoice');
    }
    public function video(){
        return $this->hasOne('App\Models\Video');
    }
    
    public function shortContent(){
        
        switch($this->post_type){
            default:
            case 'Article':
                $content=$this->postContent()->first()->content;
                $rand=mt_rand(60,100);
                $content=substr($content,0,$rand);
                return $content;
                break;
            case 'Notice':
                $content=$this->postContent()->first()->content;
                $rand=mt_rand(60,100);
                $content=substr($content,0,$rand);
                return $content;
                break;
            case 'Document':
                $content=$this->postContent()->first()->content;
                return $content;
                break;
            case 'Fact':
                $content=$this->postContent()->first()->content;
                return $content;
                break;
            case 'MCQ':
                $content=$this->postContent()->first()->content;
                return $content;
                break;
            case 'Video':
                $content=$this->postContent()->first()->content;
                return $content;
                break;
        }
    }
    public function postContent(){
        switch($this->post_type){
            default:
            return $this->article();
                break;
            case 'Article':
                return $this->article();
                break;
            case 'Notice':
                return $this->notice();
                break;
            case 'Document':
                return $this->document();
                break;
            case 'Fact':
                return $this->fact();
                break;
            case 'MCQ':
                return $this->MCQ();
                break;
            case 'Video':
                return $this->video();
                break;
        }
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function getUserNameAttribute(){
        return $this->user()->first()->full_name;
    }
    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }           
    public function tags(){
        return $this->hasMany('App\Models\PostTag');
    }           
    public function getTotalViewsAttribute(){
        return $this->hasMany('App\Models\View')->count();
    }
    public function getTotalLikesAttribute(){
        return $this->hasMany('App\Models\Like')->count();
    }
    
}
