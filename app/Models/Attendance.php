<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Attendance extends Model
{
    use HasFactory;
    protected $table ="attendance";
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use Loggable;

}
