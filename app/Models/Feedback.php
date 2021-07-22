<?php
 
 namespace App\Models;

 use Illuminate\Database\Eloquent\Model;
 use Haruncpi\LaravelUserActivity\Traits\Loggable;

 class Feedback extends Model
 {
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'feedbacks';
    use Loggable;

 }

