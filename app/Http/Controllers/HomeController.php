<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ViewPost;
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

    public function index(){
        $posts=ViewPost::where('college_id',Auth::user()->college_id)
        // ->orWhere('classroom_id',Auth::user()->classroom_id)
        // ->orWhere('branch_id	',Auth::user()->branch_id	)
        // ->orWhere('course_id',Auth::user()->course_id)
        // ->orWhere('batch_id',Auth::user()->batch_id)
        ->get();
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }

}
