<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstituteContact extends Model
{
    use HasFactory;
    protected $table ="institute_contactus";
    public function institute(){
        return $this->hasOne('App\Models\institute');
    }
}
