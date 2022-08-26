<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Models\Post;
use App\Models\ClassroomResource;
use App\Models\ChatroomMessage;
use App\Models\Doubt;
use App\Models\Comment;
use App\Models\Homework;
use App\Models\ScheduledJob;

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
            $model = ChatroomMessage::class;
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

     public function create($commentable_type, $commentable_id, Request $request){
        $me=$request->user('api');
         switch($commentable_type){
            case 'post':
            $commentable=Post::findOrFail($commentable_id);
            $model = Post::class;
            break;
            case 'doubt':
            $commentable=Doubt::findOrFail($commentable_id);
            $model = Doubt::class;
            break;
            case 'resource':
            $commentable=ClassroomResource::findOrFail($commentable_id);
            $model = ClassroomResource::class;
            break;
            case 'message':
            $commentable=ChatroomMessage::findOrFail($commentable_id);
            $model = ChatroomMessage::class;
            break;
            case 'homework':
            $commentable=Homework::findOrFail($commentable_id);
            $model = Homework::class;
            break;
            default:
            abort(404); 
        }
        
        $comment = Comment::create([
            'user_id'=>$me->id,
            'commentable_id'=>$commentable_id,
            'commentable_type'=>$model,
            'comment_text'=>$request->comment_text ,
        ]);
        if($model===Post::class){
            \App\Models\SthubPost::addAction('comment',$commentable,$me);
        }
        ScheduledJob::NewCommentNotification($comment, $commentable->user->id);
        
        return response()->json([
            'success'=>[
                'comment_id'=>$comment->id,
            ]]);
     }

     public function update(Comment $comment ,Request $request){
        $comment->update([
            'comment_text'=>$request->comment_text ,
        ]);
        return response()->json([
            'success'=>[
                'comment_id'=>$comment->id,
            ]]);
     }

     public function delete(Comment $comment){
        $comment->delete();
        if($commentable_type===Post::class){
            \App\Models\SthubPost::deleteAction('comment',$commentable,$me);
        }
        return response()->json([], 204);
      }
}
