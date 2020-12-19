<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SthubPost;
use App\Models\PostImage;
use App\Models\Article;
use App\Models\Subject;
use App\Models\CourseSubject;
use App\Models\Video;
use App\Models\Notice;
use App\Models\Fact;
use App\Models\Mcq;
use Auth;
use DB;
use Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    //
    public function create(Request $request){

        $data=$request->all();
        $post_type=$data['post_type'];
        $heading=$data['heading'];
        $student=Auth::student();
        if(is_null($student)){
          abort(403);
        }
        DB::beginTransaction();
        try{
            if(intval($data['subject_id'])===0){
                $subject_name=strtolower($data['subject_name']);
                $subject=Subject::firstOrCreate([
                  'subject_url'=>\Str::slug($subject_name),
                  'category_id'=>$data['category_id']
                ],[
                'subject_name'=>$subject_name
                ]);

                CourseSubject::firstOrCreate([
                  'course_id'=>$student->courseId,
                  'subject_id'=>$subject->id
                ]);
            }else{
                $subject=Subject::findOrFail($data['subject_id']);
            }

        $post=new Post;
        $post->user_id=Auth::user()->id;
        $post->post_heading=$heading;
        $post->subject_id=$subject->id;


        switch(strToLower($request->post_type)){
            case 'article':
                $article=new Article;
                $post_content_id=$article->createFromContent($data);
                $post->postable_type="App\Models\Article";
                $post->primary_image_path='/storage/article-default.png';
                $post->postable_id=$post_content_id;

            break;
            case 'notice':
                $notice=new Notice;
                $post_content_id=$notice->createFromContent($data);
                $post->postable_type="App\Models\Notice";
                $post->postable_id=$post_content_id;
            break;
            case 'document':
             $document=new Document;
             $post_content_id=$document->createNewDocument($data,'public');
             $post->postable_type="App\Models\Document";
             $post->postable_id=$post_content_id;
            break;
            case 'video':
            $video=new Video;
            $post_content_id=$video->createNewVideo($data);
            $post->primary_image_path='https://img.youtube.com/vi/'.$data['video_id'].'/0.jpg';
            $post->postable_type="App\Models\Video";
            $post->postable_id=$post_content_id;
            break;
            case 'mcq':
            $mcq=new Mcq;
            $post_content_id=$mcq->createNewMcq($data);
            $post->primary_image_path='/storage/mcq-default.png';
            $post->postable_type="App\Models\Mcq";
            $post->postable_id=$post_content_id;
            break;
            case 'fact':
            $fact=new Fact;
            [$post_content_id,$file_path]=$fact->createNewFact($data);
            $post->primary_image_path=$file_path;
            $post->postable_type="App\Models\Fact";
            $post->postable_id=$post_content_id;
            break;
        }

        $post->save();

        SthubPost::create([
            'post_id'=>$post->id,
            'institute_id'=>$student->instituteId,
            'course_id'=>$student->courseId,
            'shared_by'=>Auth::user()->id,
        ]);

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('Post Creation failure: for user id#'.Auth::user()->id.' with data '.implode(', ',Arr::flatten($data)));
        return response()->$e;
    }
        return response()->json(['success'=>[
          'message'=>'Post Successfully Created',
        ]]);
    }

    public function getPosts(Request $request){
        $post=new \App\Post;
        if(Auth::student()){
            return $post->getStudentPosts($request);
        }else{
            return $post->getSeekerPosts($request);
        }
    }

    public function show($post_id){
        $user=Auth::user();
        if($user){
            \App\Models\PostView::firstOrCreate([
                'post_id'=>$post_id,
                'user_id'=>$user->id,
            ]);
        }

        $post=new \App\Post;
        if($user){
          $post_content=$post->getAuthPostContent($post_id)[0];
        }else{
          $post_content=$post->getGuestPostContent($post_id)[0];
        }

        $most_viewed=$post->getMostViewedPosts($post_content->category_id);
        $most_liked=$post->getMostLikedPosts($post_content->category_id);

        return response()->json(['success'=>[
            'post_content'=>$post_content,
            'most_viewed'=>$most_viewed,
            'most_liked'=>$most_liked,
        ]]);
    }

    public function searchPosts(Request $request){
      $post=new \App\Post;
      $response = $post->getSearchPosts($request);

        $search=new \App\Models\Search;
        $search->query=$request->input('query');
        // $search->type='query';
        if($response){
          $search->success=true;
        }else{
          $search->success=false;
        }
        $search->save();

        return $response;
      }

      public function coursePosts(Request $request){
        $post=new \App\Post;
        $response = $post->getCoursePosts($request);

        $search=new \App\Models\Search;
        $search->query=$request->route('courseUrl');
        // $search->type='course';
        if($response){
          $search->success=true;
        }else{
          $search->success=false;
        }
        $search->save();

        return $response;
      }

      public function subjectPosts(Request $request){
        $post=new \App\Post;
        $response = $post->getSubjectPosts($request);

        $search=new \App\Models\Search;
        $search->query=$request->route('subjectUrl');
        // $search->type='subject';
        if($response){
          $search->success=true;
        }else{
          $search->success=false;
        }
        $search->save();

        return $response;
      }

      public function categoryPosts(Request $request){
        $post=new \App\Post;
        $response = $post->getCategoryPosts($request);

        $search=new \App\Models\Search;
        $search->query=$request->route('categoryUrl');
        // $search->type='category';
        if($response){
          $search->success=true;
        }else{
          $search->success=false;
        }
        $search->save();

        return $response;
      }

      public function savePost(Request $request){
        $save_post=new \App\Models\SavedPost();
        $save_post->user_id=Auth::user()->id;
        $save_post->post_id=$request->post_id;
        $save_post->save();
        return response()->json(['success'=>[
          'post_save'=>true,
        ]]);
      }

      public function reportPost(Request $request){
        $report_post=new \App\Models\PostReport();
        $report_post->user_id=Auth::user()->id;
        $report_post->post_id=$request->post_id;
        $report_post->save();
        return response()->json(['success'=>[
          'user_like'=>true,
        ]]);
      }
}
