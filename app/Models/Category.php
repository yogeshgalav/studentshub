<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected  $guarded = ['id', 'name', 'slug'];

    protected static function boot()
    {
        parent::boot();

        statis::addGlobalScope('sortAlpha', function(Buillder $builder) {
            $builder->whereNull('parent_category_id')->orderBy('name');
        });
    }
    public function courses(){
        return $this->hasMany('App\Models\Course');
    }
    public function subjects(){
        return $this->hasMany('App\Models\Subject');
    }
}
