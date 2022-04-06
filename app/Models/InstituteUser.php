<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstituteUser extends Model
{
    //
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if(!self::where(['institute_id'=>$model->institute_id])->exists()){
                $model->role='admin';
            }
        });
    }
    public function institute(){
        return $this->belongsTo('App\Model\Institute');
    }

    public function user(){
        return $this->belongsTo('App\Model\User');
    }

}
