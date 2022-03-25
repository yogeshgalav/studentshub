<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserParent extends Model
{
    use HasFactory;
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function parent()
    {
        return $this->belongsTo(User::class,'parent_user_id');
    }
}
