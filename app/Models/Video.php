<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    public function createNewVideo($data){
    
        $post_content_id=self::insertGetId([
        'video_id'=>$data['video_id'],
        'video_type'=>'youtube',
        'content'=>$data['video_description'] ?? null
        ]);
        return $post_content_id;
    }
}
