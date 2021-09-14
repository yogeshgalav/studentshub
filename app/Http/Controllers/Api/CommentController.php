<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Models\Post;
use App\Models\ClassroomResource;
use App\Models\ClassroomMessage;
use App\Models\Doubt;
use App\Models\Comment;
use App\Models\Homework;

class CommentController extends Controller
{

public function get($commentable_type, $commentable_id)
{
    switch($commentable_type){
        case 'post':
        $model = Post::class;
        break;
        case 'doubt':
        $model = Doubt::class;
        break;
        case 'resource':
        $model = ClassroomResource::class;
        break;
        case 'message':
        $model = ClassroomMessage::class;
        break;    
        case 'homework':
        $model = Homework::class;
        break;    
    }

    $comments = Comment::where('commentable_type',$model)
    ->where('commentable_id',$commentable_id)
    ->leftJoin('users as us','comments.user_id','=','us.id')
    ->select('us.full_name as user_name','comments.id','comments.comment_text')
    ->get();

    return response()->json([
        'success'=>[
            'comments'=>$comments,
        ]]);
}

     public function create(Request $request){
        $me=Auth::user();

         switch($request->commentable_type){
            case 'post':
            $model = Post::class;
            break;
            case 'doubt':
            $model = Doubt::class;
            break;
            case 'resource':
            $model = ClassroomResource::class;
            break;
            case 'message':
            $model = ClassroomMessage::class;
            break;
            case 'homework':
            $model = Homework::class;
            break; 
        }
    
        $comment = Comment::create([
            'user_id'=>$me->id,
            'commentable_id'=>$request->commentable_id,
            'commentable_type'=>$model,
            'comment_text'=>$request->comment_text ,
        ]);
        return response()->json([
            'success'=>[
                'comment_id'=>$comment->id,
            ]]);
     }
}
