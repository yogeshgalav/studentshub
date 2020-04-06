<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Post extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

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
    
   
    public function postable(){
        return $this->morphTo();
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
    public function image(){
        return $this->hasMany('App\Models\PostImage');
    }           
    public function tags(){
        return $this->hasMany('App\Models\PostTag');
    }           
    public function getTotalViewsAttribute(){
        return $this->hasMany('App\Models\View')->count();
    }
    public function getTotalLikesAttribute(){
        return $this->like->where('like',1)->count();
    }
    public function getTotalDislikesAttribute(){
        return $this->like->where('like',0)->count();
    }
    public function like(){
        return $this->hasMany('App\Models\Like');
    }
    public function scopeGetGuestPostContent(){
        
        return [
            'id'=>$this->id,
            'content'=>$this->postable()->first(),
            'post_type'=>$this->post_type,
            'heading'=>$this->post_heading,
            'user_name'=>$this->user_name,
            'subject_name'=>$this->subject->Subject_name,
            'created_at'=>$this->created_at,
            'total_views'=>$this->total_views,
            'total_likes'=>$this->total_likes,
            'total_dislikes'=>$this->total_dislikes,
        ];
    }
    public function getPostTypeAttribute(){
        switch($this->postable_type){
            case 'App\Models\Article':
                return 'article';
            case 'App\Models\Video':
                return 'video';
        }
    }
    public function scopeGetSeekerPostContent(){

        $post_like=$this->like->where('user_id',Auth::user()->id)->first();
        return [
            'id'=>$this->id,
            'content'=>$this->postable()->first(),
            'post_type'=>$this->post_type,
            'heading'=>$this->post_heading,
            'user_name'=>$this->user_name,
            'like'=>$post_like ? $post_like->like : null,
            'subject_name'=>$this->subject->Subject_name,
            'created_at'=>$this->created_at,
            'total_views'=>$this->total_views,
            'total_likes'=>$this->total_likes,
            'total_dislikes'=>$this->total_dislikes,
        ];
    }
    public function scopeGetViewContent()
    {
        $post_content=Auth::check() ? $this->getSeekerPostContent() : $this->getGuestPostContent();
        $parent_subject_id=$this->subject->parent_subject_id;
        $subjects=Subject::where('parent_subject_id',$parent_subject_id)
        ->where('id','!=',$this->subject_id)
        ->limit(6)->get();
        $related_posts=[];
        foreach($subjects as $subject){
            $post=$subject->posts()->first();
            is_null($post)?'':$related_posts[]=$post;
        }
        
        return ['categories'=>$subjects,'post_content'=>$post_content,'related_posts'=>$related_posts];
    }
    
}
