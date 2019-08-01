<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostContent;
use App\Models\Article;
use Auth;

class PostController extends Controller
{
    public function submitPost(Request $request){
        $post_type=$request->input('post_type');
        $subject=$request->input('post_subject');
        $heading=$request->input('post_heading');
        $content=$request->input('post_content');

        $post=new Post;
        $post->user_id=Auth::user()->id;
        $post->subject_id=1;
        $post->post_type=$post_type;
        $post->post_heading=$heading;
        $post->save();

        switch('article'){
            case 'article':
            $post_content_id=Article::create(['post_id'=>$post->id,'content'=>$content]);
            break;
            case 'notice':
            break;
            case 'document':
            break;
        }
        return response()->json('success');
    }

    public function getDashboardPost(){
        $poosts=ViewPost::where('college_id',Auth::user()->college_id)->orWhere('batch_id',Auth::user()->batch_id)->get();
    }

    public function getExplorePost(){
        $poosts=ViewPost::whereIn('type',['article','fact','video'])->get();
    }
}
