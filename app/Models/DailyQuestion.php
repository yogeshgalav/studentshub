<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyQuestion extends Model
{
    protected $guarded = [
        'id'
    ];

    public function multipleChoice(){
        return $this->hasMany(MultipleChoice::class);
    }
}
