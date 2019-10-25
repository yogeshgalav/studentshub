<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SthubPost;
use App\Models\PostContent;
use App\Models\Article;
use App\Models\Subject;
use Auth;

class PostController extends Controller
{
    //
    public function create(Request $request){
        $post_type=$request->input('post_type');
        $post_subject_id=$request->input('selected_subject_id');
        $heading=$request->input('post_heading');
        $postContent=$request->input('postContent');
try{
        $subject=Subject::findOrFail($post_subject_id);
        $post=new Post;
        $post->user_id=Auth::user()->id;
        $post->post_type=$post_type;
        $post->post_heading=$heading;
        $post->subject_id=$subject->id;
        $post->save();

        switch('article'){
            case 'article':
            $post_content_id=Article::create(['post_id'=>$post->id,'content'=>$postContent['content']])->id;
            break;
            case 'notice':
            break;
            case 'document':
            break;
            case 'video':
            $str=$postContent['video_link'];
            if ($pos=strpos($str, 'watch?v=') !== false) {
                $link='https://www.youtube.com/embed/'.substr($str, $pos);
            }else if ($pos=strpos($str, 'youtu.be/') !== false) {
                $link='https://www.youtube.com/embed/'.substr($str, $pos);
            }
            $post_content_id=Video::create(['post_id'=>$post->id,
            'link'=>$link,
            'description'=>$postContent['video_description'] ?? null
            ])->id;
            break;
        }
        SthubPost::create([
            'post_id'=>$post->id,
            'post_type'=>$post_type,
            // 'post_content_id'=>$post_content_id,
            'shared_by'=>Auth::user()->id,
        ]);
}catch(\Exception $e){
    Log::error('Error while creating post- '.$e->getMessage());
}
        return response()->json('success');
    }
}
