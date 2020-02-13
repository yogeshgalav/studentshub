<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public static function AuthUserCategory(){
        return \Auth::user()->student->prefferred_category;
    }
}
