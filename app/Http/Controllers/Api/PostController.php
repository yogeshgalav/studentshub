<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function create(Request $request){

        $post=new Post;
        $post->heading = $request->heading;
        $post->content = $request->content;
        $post->classroom_id = $request->classroom_id;
        $post->primary_image_url = $request->primary_image_url;
        $post->save();

        return response()->json(['success'=>[
            'message'=>'Post Successfully Created',
            'post_id'=>$post->id,
          ]]);

    }

    public function delete(Request $request){

        $post = $request->id;
        $post->delete();
        return response()->json(['success'=>[
            'message'=>'Post Successfully deleted'
          ]]);

    }

    public function edit(Request $request){

        $post = Post::find($request->id);
        $post->heading = $request->heading;
        $post->content = $request->content;
        $post->primary_image_url = $request->primary_image_url;
        $post->save();
        return response()->json(['success'=>[
            'message'=>'Post Successfully edited'
          ]]);

    }

}