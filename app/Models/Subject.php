<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facades\Sthub;

class Subject extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
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
            \Log::warning('New subject created with null category',['subject_url'=>\Str::slug($subject_name)]);

        }
        return self::firstOrCreate([
            'subject_url'=>\Str::slug($subject_name),
            'category_id'=>$category_id,
        ],[
            'subject_name'=>Sthub::ucWordSome($subject_name),
            'alias'=>Sthub::generateAlias($subject_name),
            'is_verified'=>$is_verified,
        ]);
    }
}
