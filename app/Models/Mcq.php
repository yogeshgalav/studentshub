<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mcq extends Model
{
    //
    public function createNewMcq($data){
        
        $post_content_id=self::insertGetId([
            'optionA'=>$data['mcq_option1'],
            'optionB'=>$data['mcq_option2'],
            'optionC'=>$data['mcq_option3'],
            'optionD'=>$data['mcq_option4'],
            'correct_option'=>$data['mcq_correct_option'],
            'answer'=>$data['mcq_answer'],
            ]);
            return $post_content_id;
    }
}
