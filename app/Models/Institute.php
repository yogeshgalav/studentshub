<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facades\Sthub;

class Institute extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Sthub::ucWordSome($value);
        $this->attributes['alias'] = Sthub::generateAlias($value);
    }

    public function setPlaceIdAttribute($value)
    {
        $this->attributes['place_id'] = Sthub::randomString($value);
    }
}
