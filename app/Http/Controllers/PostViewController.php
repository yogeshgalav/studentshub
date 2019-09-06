<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostViewController extends Controller
{
    //
    public function index($post_id){
        $post=Post::findOrFail($post_id)->getViewContent();
        return response()->json(['success'=>[
            'categories'=>$post['categories'],
            'content'=>$post['content'],
            'related_posts'=>$post['related_posts'],
        ]]);        
    }
}
