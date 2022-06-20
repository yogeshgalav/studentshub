<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'follows';
    use HasFactory;
    public function followable()
    {
        return $this->morphTo();
    }
    
}
