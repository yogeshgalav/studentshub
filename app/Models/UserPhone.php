<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    use HasFactory;

    public function user(){
        return $this->hasOne(User::class,'phone_id');
    }
}
