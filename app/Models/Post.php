<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

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
    
}
