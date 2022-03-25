<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facades\Sthub;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Institute extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    use Loggable;
    use HasSlug;


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    public static function getFirstOrCreateId($institute)
    {
        if($institute['id']){
            return self::find($institute['id'])->id;
        }

        if(empty($institute['name'])) return null;
        
        $new = self::firstOrCreate([
            'name'=>$institute['name'],
        ]);
        return $new->id;
    }
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Sthub::ucWordSome($value);
        $this->attributes['alias'] = Sthub::generateAlias($value);
    }

    public function setPlaceIdAttribute($value)
    {
        $this->attributes['place_id'] = Sthub::randomString($value);
    }
    public function instituteUsers(){
        return $this->hasMany('App\Models\InstituteUsers');
    }
}
