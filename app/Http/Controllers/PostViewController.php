<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostViewController extends Controller
{
    //
    public function index(){
        $post=Post::with('postContent')
        // ->with('userLike')
        ->first();
        return response()->json(['success'=>[
            'post'=>$post,
        ]]);        
    }
}
