<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use HasFactory;

    public function commentable()
    {
        return $this->morphTo();
    }
    public function getCommentableTypeString()
    {
        switch($this->commentable_type){
            case Post::class:
                return 'post';
            case Doubt::class:
                return 'doubt';
            case ClassroomMessage::class:
                return 'message';
            case ClassroomResource::class:
                return 'resource';
            case ClassroomHomework::class:
                return 'homework';
        }
        return '';
    }
}
