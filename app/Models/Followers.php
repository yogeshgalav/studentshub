<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'followers';
    use HasFactory;
    public function followable()
    {
        return $this->morphTo();
    }
    
}
