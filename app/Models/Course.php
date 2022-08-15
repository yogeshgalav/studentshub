<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facades\Sthub;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Course extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use Loggable;
    use HasSlug;


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('course_name')
            ->saveSlugsTo('slug');
    }
    public static function getFirstOrCreateId($course)
    {
        if(empty($course)){
            return null;
        }
        if($course['id']){
            return self::find($course['id'])->id;
        }

        if(empty($course['course_name'])) return null;

        $new = self::firstOrCreate([
            'course_name'=>$course['course_name'],
        ]);
        return $new->id;
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function subjects()
    {
        return $this->belongsToMany('App\Models\Subject', 'course_subjects');
    }

    public function setCourseNameAttribute($value)
    {
        $this->attributes['course_name'] = Sthub::ucWordSome($value);
        $this->attributes['alias'] = Sthub::generateAlias($value);
    }
}
