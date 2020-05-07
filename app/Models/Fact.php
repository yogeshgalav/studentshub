<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fact extends Model
{
    //
    public function createNewFact($data){
    
        $post_content_id=self::insertGetId([
            'image'=>$data['file'],
            'description'=>$data['description'],
        ]);
        return $post_content_id;
    }
}
