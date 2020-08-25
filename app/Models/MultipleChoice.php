<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultipleChoice extends Model
{
    //
    protected $guarded = [
        'id'
    ];

    public function getIsCorrectAttribute(){
        return $this->is_correct ? true : false;
    }
}
