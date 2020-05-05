<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SthubPost;
use App\Models\SthubFile;
use App\Models\PostContent;
use App\Models\PostImage;
use App\Models\Article;
use App\Models\Subject;
use App\Models\Video;
use Auth;
use DB;
use Storage;
use Illuminate\Support\Arr;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class PostController extends Controller
{
    //
    public function create(Request $request){
        // $path =  (dirname(__FILE__) .'/../../Services/simple_html_dom.php');
        // require($path);
        
        $data=$request->all();
        $post_type=$data['post_type'];
        $selected_subject=$data['subject'];
        $heading=$data['heading'];
        DB::beginTransaction();
        try{
            if(is_null($selected_subject['id'])){
                $subject_name=strtolower($selected_subject['subject_name']);
                $subject=Subject::firstOrCreate([
                    'Subject_name'=>$subject_name,
                    'subject_url'=>urlencode($subject_name)
                    ]);   
            }else{
                $subject=Subject::findOrFail($selected_subject['id']);
            }
        
        $post=new Post;
        $post->user_id=Auth::user()->id;
        $post->post_heading=$heading;
        $post->subject_id=$subject->id;
        

        switch(strToLower($request->post_type)){
            case 'article':
                $article=new Article;
                $post_content_id=$article->createFromContent($data['articleContent']);
                $post->postable_type="App\Models\Article";
                $post->postable_id=$post_content_id;
              
            break;
            case 'notice':
                $notice=new Notice;
                $post_content_id=$notice->createFromContent($data['noticeContent']);
                $post->postable_type="App\Models\Notice";
                $post->postable_id=$post_content_id;
            break;
            case 'document':
             $document=new Document;
             $post_content_id=$document->createNewDocument($data['documentContent']);
             $post->postable_type="App\Models\Document";
             $post->postable_id=$post_content_id;
            break;
            case 'video':
            $video=new Video;
            $post_content_id=$video->createNewVideo($data['videoContent']);
            $post->primary_image_path='https://img.youtube.com/vi/'.$data['video_id'].'/0.jpg';
            $post->postable_type="App\Models\Video";
            $post->postable_id=$post_content_id;
            break;
            case 'mcq':
            $mcq=new Mcq;
            $post_content_id=$mcq->createNewMcq($data['videoContent']);
            $post->postable_type="App\Models\Mcq";
            $post->postable_id=$post_content_id;
            break;    
            case 'fact':
            $fact=new Fact;
            $post_content_id=$fact->createNewFact($data['factContent']);
            $post->postable_type="App\Models\Fact";
            $post->postable_id=$post_content_id;
            break;    
        }

        
        $post->save();

        $student=Auth::student();

        SthubPost::create([
            'post_id'=>$post->id,
            'institute_id'=>$student->instituteId,
            'course_id'=>$student->courseId,
            'shared_by'=>Auth::user()->id,
        ]);
        
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        // \Log::critical('Post Creation failure: for user id#'.Auth::user()->id.' with data '.implode(', ',Arr::flatten($data)));
        dd($e->getMessage(),$e->getLine());
        return response()->$e;
    }
        return response()->json('success');
    }

    public function getPosts(Request $request){
        $post=new \App\Post;
        if(Auth::student()){
            return $post->getStudentPosts($request);
        }else{
            return $post->getSeekerPosts($request);
        }
    }
}
