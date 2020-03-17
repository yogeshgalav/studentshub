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
        $path =  (dirname(__FILE__) .'/../../Services/simple_html_dom.php');
        require($path);
        
        $data=$request->all();
        $post_type=$data['post_type'];
        $selected_subject=$data['selected_subject'];
        $heading=$data['post_heading'];
        $postContent=$data['postContent'];

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
                $post_content_id=$article->createFromContent($postContent['content']);
                $post->postable_type="App\Models\Article";
                $post->postable_id=$post_content_id;
              
            break;
            case 'notice':
                $notice=new Notice;
                $post_content_id=$notice->createFromContent($postContent['content']);
                $post->postable_type="App\Models\Notice";
                $post->postable_id=$post_content_id;
            break;
            case 'document':
             $document=new Document;
             $post_content_id=$document->createNewDocument($request->newPost);
             $post->postable_type="App\Models\Document";
             $post->postable_id=$post_content_id;
            break;
            case 'video':
            $str=$postContent['link'].'&';
            
            if (preg_match('/(?<=watch\?v\=).*?(?=\&)/', $str, $m)) {
                $video_id = $m[0]; 
            }else if (preg_match('/(?<=www\.youtu\.be\/).*?(?=\&)/', $str, $m)) {
                $video_id = $m[0]; 
            }
            $post_content_id=Video::insertGetId([
            'link'=>'https://www.youtube.com/embed/'.$video_id,
            'content'=>$postContent['description'] ?? null
            ]);

            $post->primary_image_path='https://img.youtube.com/vi/'.$video_id.'/0.jpg';
            $post->postable_type="App\Models\Video";
            $post->postable_id=$post_content_id;
            break;
            case 'mcq':
            break;    
            case 'fact':
            break;    
        }

        
        $post->save();

        SthubPost::create([
            'post_id'=>$post->id,
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

    public function searchPosts(Request $request){
        return $this->getSeekerPosts($request);
    }

    public function getStudentPosts(){
        $posts=DB::table('sthub_posts as sp')
        ->join('posts as po','po.id','=','sp.post_id')
        ->leftJoin('articles as ar',function($join){
            $join->on('po.postable_id','=','ar.id')->where('po.postable_type','=','App\Models\Article');
        })
        ->leftJoin('documents as do',function($join){
            $join->on('po.postable_id','=','do.id')->where('po.postable_type','=','App\Models\Document');
        })
        ->leftJoin('videos as vd',function($join){
            $join->on('po.postable_id','=','vd.id')->where('po.postable_type','=','App\Models\Video');
        })
        ->leftJoin('subjects as sub','sub.id','=','po.subject_id')
        ->leftJoin('categories as cat','cat.id','=','sub.category_id')
        ->leftJoin('users as us','us.id','=','po.user_id')
        ->leftJoin('students as st','st.user_id','=','us.id')
        ->leftJoin('batches as pbt','pbt.id','=','st.prefferred_batch')
        ->leftJoin('institutes as inst','inst.id','=','pbt.institute_id')
        // ->leftJoin('notices as no','po.id','=','no.post_id')
        // ->leftJoin('facts as fa','po.id','=','fa.post_id')
        // ->leftJoin('mcqs as mc','po.id','=','mc.post_id')
        ->select(['po.id as id','po.post_heading as heading','po.postable_type as postable_type','cat.name as category_name','sub.Subject_name as subject_name','po.primary_image_path as image_path',
        'us.avatar_url as profile_image','us.full_name as user_name','inst.institute_name as institute_name','ar.content as article_content','vd.content as video_content',
        'vd.link as video_link'])
        ->orderBy('po.created_at','DESC')
        ->paginate();

     $this->formatPostData($posts);
        
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }

    public function getSeekerPosts(Request $request){
        $post_query=DB::table('sthub_posts as sp')
        ->join('posts as po','po.id','=','sp.post_id')
        ->leftJoin('articles as ar',function($join){
            $join->on('po.postable_id','=','ar.id')->where('po.postable_type','=','App\Models\Article');
        })
        ->leftJoin('videos as vd',function($join){
            $join->on('po.postable_id','=','vd.id')->where('po.postable_type','=','App\Models\Video');
        })
        ->leftJoin('subjects as sub','sub.id','=','po.subject_id')
        ->leftJoin('categories as cat','cat.id','=','sub.category_id')
        ->leftJoin('users as us','us.id','=','po.user_id');
        // ->leftJoin('facts as fa','po.id','=','fa.post_id')

        if($request->search){
            $post_query=$post_query->where('sub.Subject_name','LIKE','%'.$request->search.'%')
            ->orWhere('cat.name','LIKE','%'.$request->search.'%')
            ->orWhere('po.post_heading','LIKE','%'.$request->search.'%');
        }

        $posts=$post_query->select(['po.id as id','po.post_heading as heading','po.postable_type as postable_type','cat.name as category_name','sub.Subject_name as subject_name','po.primary_image_path as image_path',
        'us.avatar_url as profile_image','us.full_name as user_name','ar.content as article_content','vd.content as video_content',
        'vd.link as video_link'])
        ->orderBy('po.created_at','DESC')
        ->paginate();

        $this->formatPostData($posts);
        
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }

    public function getPostType($post_type){
        switch($post_type){
            case 'App\Models\Article':
                return 'article';
            case 'App\Models\Video':
                return 'video';
            case 'App\Models\Fact':
                return 'fact';
            case 'App\Models\Document':
                return 'document';
            case 'App\Models\Notice':
                return 'notice';
        }
    }

    public function formatPostData($posts){
           //get groupBy fields
           foreach($posts as $post){
            $rand=rand(60,100);
            $postData=DB::table('posts as po')->where('po.id',$post->id)
            ->leftJoin('likes as li','po.id','=','li.post_id')
            ->leftJoin('views as vw','po.id','=','vw.post_id')
            ->select([DB::raw('COUNT(distinct li.user_id) as total_likes'),DB::raw('COUNT(distinct vw.user_id) as total_views')])
            ->groupBy(['po.id'])
            ->first();

            $post->post_type=$this->getPostType($post->postable_type);
            switch($post->post_type){
                case 'article':
                    $post->content=substr($post->article_content,$rand).'...';        
                break;
                case 'video':
                    $post->content=substr($post->video_content,$rand).'...';        
                break;
            }
            $post->total_likes=$postData->total_likes;
            $post->total_views=$postData->total_views;
        }

        return $posts;
    }
}
