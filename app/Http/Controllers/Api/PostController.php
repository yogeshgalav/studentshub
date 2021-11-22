<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

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
use App\Models\Document;
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
        $heading=$data['heading'];
        
        DB::beginTransaction();
        try{

        $post=new Post;
        $post->user_id=Auth::user()->id;
        $post->post_heading=$heading;
        $post->category_id = $data['category_id'];

        switch(strToLower('article')){
            case 'article':
                $article=new Article;
                $post_content_id=$article->createFromContent($data);
                $post->postable_type="App\Models\Article";
                $post->primary_image_path=null;
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

             $post->primary_image_path='/images/document.png';
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

        $post->created_via='dashboard';
        $post->post_description = $data['description'];
        $post->save();

        Subject::addPostTags($post, $request->selected_subjects);
        SthubPost::addAction('share',$post,Auth::user());

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::warning('Post Creation failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
        return response()->$e;
    }
    Log::info('New Post created',[
      'user_id'=>$request->user('api')->id,
      'heading'=>$request->heading,
    ]);
        return response()->json(['success'=>[
          'message'=>'Post Successfully Created',
        ]]);
    }
    public function update(Post $post, Request $request){

      $data=$request->all();
      if(Auth::id()!==$post->user_id){
        abort(403);
      }
      DB::beginTransaction();
      try{
    
      $post->post_heading=$data['heading'];
      $post->subject_id=$subject?$subject->id:NULL;
      $post->category_id = $data['category_id'];

      switch($post->postable_type){
          case Article::class:
              Article::where('id', $post->postable_id)
              ->update([
                'html_content'=>$data['article_html_content'],
              ]);

          break;
          case Document::class:
              Document::where('id', $post->postable_id)
              ->update([
                'link'=>$data['document_link'],
              ]);

          break;
          case Video::class:
              Video::where('id', $post->postable_id)
              ->update([
                'video_id'=>$data['video_id'],
              ]);
          break;
      }

      $post->post_description = $data['description'];
      $post->save();

      DB::commit();
  } catch (\Exception $e) {
      DB::rollback();dd($e->getMessage());
      Log::warning('Post Updation failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
      return response()->$e;
  }
      return response()->json(['success'=>[
        'message'=>'Post Successfully Created',
      ]]);
  }

    public function getPosts(Request $request){
        $post=new \App\Post;
        $posts = $post->getAuthUserPosts($request);
        return response()->json(['success'=>[
          'posts'=>\Sthub::convert_from_latin1_to_utf8_recursively($posts)
      ]]);
    }

    public function show(Post $post){
        $me=Auth::user();
        if($me && $me->id!==$post->user_id){
          \App\Models\SthubPost::addAction('view',$post,$me);
          \App\Models\PostView::firstOrCreate([
            'post_id'=>$post->id,
            'user_id'=>$me->id,
          ]);
        }

        $post_helper=new \App\Post;
        if($me){
          $post_content=$post_helper->getAuthPostContent($post->id)[0];
        }else{
          $post_content=$post_helper->getGuestPostContent($post->id)[0];
        }

        $most_viewed=$post_helper->getMostViewedPosts($post_content->category_id);
        $most_liked=$post_helper->getMostLikedPosts($post_content->category_id);

        return response()->json(['success'=>[
            'post_content'=>$post_content,
            'most_viewed'=>\Sthub::convert_from_latin1_to_utf8_recursively($most_viewed),
            'most_liked'=>\Sthub::convert_from_latin1_to_utf8_recursively($most_liked),
        ]]);
    }
    public function courseDetails(Request $request){
        $subject=\App\Models\Course::where('slug', $request->route('id'))->firstOrFail();
        $post=new \App\Post;
        $posts = $post->getCoursePosts($course->id);

        return response()->json(['success'=>[
            'posts'=>\Sthub::convert_from_latin1_to_utf8_recursively($posts),
            'subject'=>$course,
        ]]);
      }
      public function subjectDetails(Request $request){
        $subject=\App\Models\Subject::where('slug', $request->route('id'))->firstOrFail();
        $post=new \App\Post;
        $posts = $post->getSubjectPosts($subject->id);

        return response()->json(['success'=>[
            'posts'=>\Sthub::convert_from_latin1_to_utf8_recursively($posts),
            'subject'=>$subject,
        ]]);
      }

      public function categoryDetails(Request $request){
        $category=\App\Models\Category::where('category_url', $request->route('id'))->with('courses')->with('subjects')->firstOrFail();
        $post=new \App\Post;
        $posts = $post->getCategoryPosts($category->id);

        return response()->json(['success'=>[
            'posts'=>\Sthub::convert_from_latin1_to_utf8_recursively($posts),
            'category'=>$category,
        ]]);
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

      public function delete(Post $post){
        $post->delete();
        SthubPost::where('post_id', $post->id)->delete();

        return response()->json([],204);
    }
}
