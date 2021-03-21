<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function descriptiveQuestions(){
        return $this->hasMany('App\Models\DescriptiveQuestion');
    }
    
    public function dailyAssignments(){
        return $this->hasMany('App\Models\DailyAssignment');
    }
    public function classroomResources(){
        return $this->hasMany('App\Models\ClassroomResource');
    }

    public function setUnitNameAttribute($value)
    {
        $this->attributes['unit_name'] = ucfirst($value);
    }
}
