<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getPrefferredCourseAttribute(){
        return Batch::where('id',$this->prefferred_batch)->first()->course_id;
    }
}
