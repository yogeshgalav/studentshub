<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Storage;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Article extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use Loggable;
}
