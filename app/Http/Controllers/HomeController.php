<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SthubPost;
use App\Models\PostContent;
use App\Models\Article;
use Auth;

class HomeController extends Controller
{
    public function create(Request $request){
        $post_type=$request->input('post_type');
        $subject=$request->input('post_subject');
        $heading=$request->input('post_heading');
        $content=$request->input('post_content');

        $post=new Post;
        $post->user_id=Auth::user()->id;
        $post->post_type=$post_type;
        $post->post_heading=$heading;
        $post->save();

        switch('article'){
            case 'article':
            $post_content_id=Article::create(['post_id'=>$post->id,'content'=>$content])->id;
            break;
            case 'notice':
            break;
            case 'document':
            break;
        }
        SthubPost::create([
            'post_id'=>$post->id,
            // 'post_content_id'=>$post_content_id,
            'shared_by'=>Auth::user()->id,
        ]);
        return response()->json('success');
    }

    public function index(){
        $posts=SthubPost::getDashboardPosts();
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }

}
