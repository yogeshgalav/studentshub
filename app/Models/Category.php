<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\CategoryScope;

class Category extends Model
{
    protected  $guarded = ['id', 'name', 'slug'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new CategoryScope);
    }
    
    public function courses(){
        return $this->hasMany('App\Models\Course');
    }
    public function subjects(){
        return $this->hasMany('App\Models\Subject');
    }
}
