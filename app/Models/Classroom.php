<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function post(){
        return $this->hasMany(Post::class, 'post_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function institute(){
        return $this->belongsTo(Institute::class, 'institute_id');
    }

    public function classroomFollower(){
        return $this->hasMany(ClassroomFollower::class, 'classroom_id');
    }


}
