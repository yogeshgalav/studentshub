<?php
namespace App\Models\Traits;

use Ramsey\uuid\uuid as Packageuuid;

trait uuid
{

    public function scopeuuid($query, $uuid)
    {
        return $query->where($this->getuuidName(), $uuid);
    }

    public function getuuidName()
    {
        return property_exists($this, 'uuidName') ? $this->uuidName : 'uuid';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getuuidName()} = Packageuuid::uuid4()->toString();
        });
    }
}