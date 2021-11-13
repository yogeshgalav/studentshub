<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Doubt extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use HasSlug;


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('question')
            ->saveSlugsTo('slug');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function subjects(){
        return $this->belongsToMany(Subject::class, 'doubt_tags');
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function setQuestionAttribute($value)
    {
        $this->attributes['question'] = ucfirst($value);
    }
    public function copyTags(Post $post)
    {
        \DB::statement('INSERT INTO post_tags (post_id,subject_id)
        SELECT '.$post->id.',subject_id
        FROM doubt_tags where doubt_id='.$this->id);
        return true;
    }
}
