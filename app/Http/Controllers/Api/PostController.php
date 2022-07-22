<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SthubPost;
use App\Models\ScheduledJob;
use App\Models\PostImage;
use App\Models\Article;
use App\Models\Subject;
use App\Models\CourseSubject;
use App\Models\Video;
use App\Models\Notice;
use App\Models\Fact;
use App\Models\Mcq;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Document;
use Auth;
use DB;
use Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use App\Services\simple_html_dom;

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
        $post->course_id = $data['course_id'] ?? null;
        $post->classroom_id = $data['classroom_id'] ?? null;

        $simple_html_dom = new simple_html_dom;
        $dom = $simple_html_dom->extactImageFiles($data['html_content'], "post-image");
        $post_content= Article::create(['html_content'=>$dom->html]);

        foreach($dom->files as $file){
            $newFile= new SthubFile();
            $newFile->fileable_id=$post_content->id;
            $newFile->fileable_type=Article::class;
            $newFile->file_ext=Storage::disk('post-image')->getMimeType($file);
            $newFile->file_size=Storage::disk('post-image')->size($file);
            $newFile->file_name=$file;
            $newFile->user_id=Auth::user()->id;
            $newFile->save();
        }
        $primary_image_path='';
        if(count($dom->files)){
          $primary_image_path=$dom->files[0];
        } else {
          $primary_image_path= $simple_html_dom->extractYoutubeImage($data['html_content']);
        }

        $post->postable_type="App\Models\Article";
        $post->primary_image_path=$primary_image_path;
        $post->postable_id=$post_content->id;

        if($request->course){
          $post->course_id=$request->course['id'];
        }

        $post->created_via='dashboard';
        $post->post_description = $data['text_content'];
        $post->save();

        Subject::addPostTags($post, $request->subjects);
        SthubPost::addAction('share',$post,Auth::user());
        ScheduledJob::newPostNotification($post);

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
          'post_id'=>$post->id,
        ]]);
    }
    public function update(Post $post, Request $request){
      $data=$request->all();
      if($request->user('api')->id !== $post->user_id){
        abort(403);
      }
      DB::beginTransaction();
      try{
    
      $post->post_heading=$data['heading'];
      $post->category_id = $data['category_id'];

      switch($post->postable_type){
          case Article::class:
              Article::where('id', $post->postable_id)
              ->update([
                'html_content'=>$data['html_content'],
              ]);

          break;
      }

      $post->post_description = $data['text_content'];
      $post->save();

      Subject::deletePostTags($post);
      Subject::addPostTags($post, $request->subjects);

      DB::commit();
  } catch (\Exception $e) {
      DB::rollback();dd($e->getMessage());
      Log::warning('Post Updation failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
      return response()->$e;
  }
      
    return response()->json(['success'=>[
      'message'=>'Post Successfully updated',
      'post_id'=>$post->id,
    ]]);
  }

    public function getPosts($dashboard_type=null,$dashboard_id=null,Request $request){
        $post_repo=new \App\Post;
        $post_query=$post_repo->getAuthUserPostTabels();
        $post_query=$post_query->orderBy('po.created_at','DESC');

        switch($dashboard_type){
          case 'institute':
            $post_query=$post_query->where('inst.id',$dashboard_id);
            break;
          case 'course':
            $post_query=$post_query->where('po.course_id',$dashboard_id);
            break;
          case 'subject':
            $post_query=$post_query->leftJoin('post_tags as pt','pt.post_id','=','po.id')
            ->where('pt.subject_id',$dashboard_id);
            break;
          case 'category':
            $post_query=$post_query->where('cat.id',$dashboard_id);
            break;
          case 'user':
            $post_query=$post_query->where('po.user_id',$dashboard_id);
            break;
          default:
            $post_query=$post_query;
            break;
        }

        if($request->user('api')){
          $posts=$post_repo->formatPostData($post_query->paginate(10));
        }else{
          $posts['data']=$post_repo->formatPostData($post_query->limit(10)->get());
        }
        
        return response()->json(['success'=>[
          'posts'=>$posts,
        ]]);
    }

    
    public function searchPosts(Request $request){
        if(empty($request->searchTerm)){
            return response()->json([
                'success'=>[
                    'posts'=>[],
                ]
            ]);
        }
        $post=new \App\Post;
        $posts = $post->getSearchPosts($request);

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

      public function savePost(Request $request){
        $save_post=new \App\Models\SavedPost();
        $save_post->user_id=Auth::user()->id;
        $save_post->post_id=$request->post_id;
        $save_post->save();
        \Log::warning('New Saved post', [
          'user_id'=>$save_post->user_id,
          'post_id'=>$save_post->post_id,
        ]);
        return response()->json(['success'=>[
          'post_save'=>true,
        ]]);
      }

      public function reportPost(Request $request){
        $report_post=new \App\Models\PostReport();
        $report_post->user_id=$request->user('api')->id;
        $report_post->post_id=$request->post_id;
        $report_post->save();
        \Log::warning('New Report Added', [
          'user_id'=>$report_post->user_id,
          'post_id'=>$report_post->post_id,
        ]);
        return response()->json(['success'=>[
          'user_like'=>true,
        ]]);
      }

      public function delete(Post $post){
        
        Like::where('likable_id', $post->id)->where('likable_type', Post::class)->delete();
        Comment::where('commentable_id', $post->id)->where('commentable_type', Post::class)->delete();
        SthubPost::where('post_id', $post->id)->delete();
        $post->delete();

        return response()->json([],204);
    }

    public function getPostsviews($postId){
      $reactions = DB::table('sthub_posts as st')->where('st.post_id','=',$postId)
      ->leftjoin('users as us', 'us.id','=','st.action_user_id')
      ->select('st.action_type','st.post_id','us.full_name', 'us.id')->get();

      return response()->json(['success'=>[
        'reactions'=>$reactions,
      ]]);
    }
}
