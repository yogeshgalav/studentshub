<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facades\Sthub;

class Course extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

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
        $this->attributes['course_url'] = \Str::slug($value);
        $this->attributes['alias'] = Sthub::generateAlias($value);
    }
}
