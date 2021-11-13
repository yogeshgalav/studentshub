<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Auth;
use DB;
use Carbon\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends=['user_name','total_views','total_likes'];
    use HasSlug;


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('post_heading')
            ->saveSlugsTo('slug');
    }
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
    public function subjects(){
        return $this->belongsToMany(Subject::class, 'post_tags');
    }         
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }           
    public function sthubPosts(){
        return $this->hasMany(SthubPost::class);
    }           
    public function image(){
        return $this->hasMany('App\Models\PostImage');
    }           
    public function tags(){
        return $this->hasMany('App\Models\PostTag');
    }           
    public function getTotalViewsAttribute(){
        return $this->hasMany('App\Models\PostView')->count();
    }
    public function getTotalLikesAttribute(){
        return $this->like->where('like_status',1)->count();
    }
    public function like(){
        return $this->morphMany('App\Models\Like', 'likable');
    }
    
    public function getPostTypeAttribute(){
        switch($this->postable_type){
            case 'App\Models\Article':
                return 'article';
            case 'App\Models\Video':
                return 'video';
        }
    }
    // public static function boot() {
    //     parent::boot();
    //     static::created(function (Post $post) {
    //            Interest::updateOrCreate([
    //            'user_id'=>$post->user_id,
    //            'category_id'=>$post->category_id,
    //            ], [
    //            'total_posts'=>DB::raw('total_posts+1'),
    //            ]);
    //     });
    // }
    
}
