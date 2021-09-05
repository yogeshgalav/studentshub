<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Homework extends Model
{
    use HasFactory;    
    use Loggable;
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    protected  $table = 'homeworks';
    protected $casts = ['submission_date' => 'date'];
    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }
}
