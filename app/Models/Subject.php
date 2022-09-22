<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facades\Sthub;
use Illuminate\Support\Facades\Auth;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
class Subject extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use HasSlug;


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('subject_name')
            ->saveSlugsTo('slug');
    }
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }
    public function votes(){
        return $this->morphMany(Vote::class, 'votable');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Models\Course', 'course_subjects');
    }
    public function course_subjects()
    {
        return $this->hasMany('App\Models\CourseSubject');
    }

    public static function getOrCreate($subject_id, $subject_name, $category_id, $is_verified=false){
        if(!empty($subject_id)){
            return self::findOrFail($subject_id);
        }
        if(empty($category_id)){
            \Log::warning('New subject created with null category',['slug'=>\Str::slug($subject_name)]);
        }
        return self::firstOrCreate([
            'slug'=>\Str::slug($subject_name),
            'category_id'=>$category_id,
        ],[
            'subject_name'=>Sthub::ucWordSome($subject_name),
            'alias'=>Sthub::generateAlias($subject_name),
            'is_verified'=>$is_verified,
            'added_by_user_id'=>Auth::id(),
        ]);
    }
    public static function addDoubtTags(Doubt $doubt, $tags)
    {
        foreach($tags as $tag){
            $subject = self::firstOrCreate([
                'subject_name'=>Sthub::ucWordSome($tag['text']),
                'category_id'=>$doubt->category_id,
            ],[
                'alias'=>Sthub::generateAlias($tag['text']),
                'is_verified'=>false,
                'added_by_user_id'=>Auth::id(),
            ]);
            DoubtTag::firstOrCreate([
                'subject_id'=>$subject->id,
                'doubt_id'=>$doubt->id,
            ]);
        }
        
        return true;
    }
    public static function deleteDoubtTags($doubt)
    {
        $doubt->delete();
        return response()->json([], 204);
        
    }
    
    public static function addPostTags(Post $post, $tags)
    {
        if(empty($tags)){
            return false;
        }
        
        foreach($tags as $tag){
            $subject = self::firstOrCreate([
                'subject_name'=>Sthub::ucWordSome($tag['text']),
                'category_id'=>$post->category_id,
            ],[
                'alias'=>Sthub::generateAlias($tag['text']),
                'is_verified'=>false,
                'added_by_user_id'=>Auth::id(),
            ]);
            PostTag::firstOrCreate([
                'subject_id'=>$subject->id,
                'post_id'=>$post->id,
            ]);
        }
        
        return true;
    }
    public static function deletePostTags($post)
    {
        PostTag::where('post_id', $post->id)->delete();

        return true;
    }
}
