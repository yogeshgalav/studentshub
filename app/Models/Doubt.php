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
    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }
    public function course(){
        return $this->belongsTo('App\Models\Course');
    }

    public function setQuestionAttribute($value)
    {
        $this->attributes['question'] = ucfirst($value);
    }
}
