<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mcq extends Model
{
    //
    public function createNewMcq($data){
        
        $post_content_id=self::insertGetId([
            'option1'=>$data['option1'],
            'option2'=>$data['option2'],
            'option3'=>$data['option3'],
            'option4'=>$data['option4'],
            'answer'=>$data['answer'],
            ]);
            return $post_content_id;
    }
}
