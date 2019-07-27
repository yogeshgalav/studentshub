<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostContent;
use Auth;

class PostController extends Controller
{
    public function submitPost(Request $request){
        $subject=$request->input('subject');
        $heading=$request->input('heading');
        $content=$request->input('content');

        $post=new Post;
        $post->user_id=Auth::user()->id;
        $post->subject_id=1;
        $post->post_type='article';
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

        ViewPost::create(['post_id'=>$post->id,
                        'post_content_id'=>$post_content_id,
                        'post_type'=>'article',
                        'shared_by'=>Auth::user()->id,
        ]);
        return response()->json('success');
    }

    public function getDashboardPost(){
        $poosts=ViewPost::where('college_id',Auth::user()->college_id)->orWhere('batch_id',Auth::user()->batch_id)->get();
    }

    public function getExplorePost(){
        $poosts=ViewPost::whereIn('type',['article','fact','video'])->get();
    }
}
