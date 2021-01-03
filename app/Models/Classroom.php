<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facades\Sthub;

class Classroom extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    /***
     * Register a listener on the Classroom model's
     * 'creating' event, to have it automatically generate a
     * Join ID.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (false == $model->classroom_join_id || null == $model->classroom_join_id) {
                $model->classroom_join_id = self::generateUniqueCode(6);
            }
        });
    }

    /***
     * Generates a Join ID
     *
     * @param $num_of_chars int How many characters long should the ID be?
     *
     * @return boolean|string
     */
    public static function generateCode($num_of_chars = 6)
    {
        // Generate an ID
        $random_string = base_convert(sha1(uniqid(strval(mt_rand()))), 16, 36);
        $filtered = preg_replace('/[01io]/', '', $random_string); //Filter 0 1 O I

        return strtoupper(substr($filtered, 0, $num_of_chars));
    }

    /***
     * Generates a Unique Join ID
     *
     * @param $num_of_chars int How many characters long should the ID be?
     *
     * @return boolean|string
     * @group 1
     * @throws OutOfBoundsException
     */
    public static function generateUniqueCode($num_of_chars = 6)
    {

        // Make sure there are enough codes
        $id_count = self::count();
        $max_available_join_ids = pow(36, $num_of_chars);

        if ($id_count >= $max_available_join_ids) {
            throw new OutOfBoundsException('No Join IDs available.');
        }

        $join_id = self::generateCode($num_of_chars);

        // The code isn't unique, then call self
        // again to generate a new one.
        if (0 < self::where('classroom_join_id', '=', $join_id)->count()) {
            self::generateUniqueCode($num_of_chars);

            return false;
        }

        // The code was unique, return it
        return $join_id;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Sthub::ucWordSome($value);
    }

    public function teacher(){
        return $this->belongsTo('App\Models\Teacher');
    }
    public function batch(){
        return $this->belongsTo('App\Models\Batch');
    }
    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }
}
