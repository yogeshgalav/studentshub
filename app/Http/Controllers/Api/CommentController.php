<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function create($commentable_type, $commentable_id, Request $request){

        switch($commentable_type){
            case 'post':
            $commentable=Post::findOrFail($commentable_id);
            $model = Post::class;
            break;
            default:
            abort(404); 
        }

        $comment=new Comment;
        $comment->user_id=Auth::user()->id;
        $comment->post_id=$commentable_id;
        $comment->commentable_type=$model;
        $comment->content=$request->content;
        $comment->save();

        return response()->json(['success'=>[
            'message'=>'Comment Successfully Created'
          ]]);

    }

    public function delete(Request $request){

        $comment = $request->id;
        $comment->delete();
        return response()->json(['success'=>[
            'message'=>'Comment Successfully deleted'
          ]]);

    }

    public function edit(Request $request){

        $comment = Comment::find($request->id);
        $comment->content = $request->content;
        $comment->save();
        return response()->json(['success'=>[
            'message'=>'Comment Successfully edited'
          ]]);

    }

}