<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mcq extends Model
{
    //
    public function createNewMcq($data){
        
        $post_content_id=self::insertGetId([
            'video_id'=>$data['video_id'],
            'video_type'=>'youtube',
            'content'=>$data['description'] ?? null
            ]);
            return $post_content_id;
    }
}
