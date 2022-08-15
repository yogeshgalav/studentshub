<?php

namespace App\Helpers;

use App\Models\Post as PostModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;
use PHPHtmlParser\Dom;

class PostHelper
{
    
    public function getSearchPosts(Request $request){
        $post_query=$this->getAuthUserPostTabels();

        $posts=$post_query->leftJoin('post_tags as pt','pt.post_id','=','po.id')
        ->leftJoin('subjects as sub','pt.subject_id','=','sub.id')
        ->where('sub.subject_name','LIKE','%'.$request->input('searchTerm').'%')
        ->orWhere('cat.name','LIKE','%'.$request->input('searchTerm').'%')
        ->orWhere('po.post_heading','LIKE','%'.$request->input('searchTerm').'%')
        ->orderBy('po.created_at','DESC')
        ->limit(10)->get();

        return $this->formatPostData($posts);
    }
    public function getDoubtPosts($doubtId){
        $post_query=$this->getAuthUserPostTabels();

        $posts=$post_query->join('doubt_answers as da',function($join)use($doubtId){
            $join->on('po.id','=','da.post_id')->where('da.doubt_id','=',$doubtId);
        })
        ->orderBy('po.created_at','DESC')
        ->get();

        return $this->formatPostData($posts);
    }

    public function getAuthUserPostTabels(){
        $post_query = DB::table('sthub_posts as sp')
        ->join('posts as po','po.id','=','sp.post_id')
        ->leftJoin('articles as ar',function($join){
            $join->on('po.postable_id','=','ar.id')->where('po.postable_type','=','App\Models\Article');
        })
        ->leftJoin('videos as vd',function($join){
            $join->on('po.postable_id','=','vd.id')->where('po.postable_type','=','App\Models\Video');
        })
        ->leftJoin('categories as cat','cat.id','=','po.category_id')
        ->leftJoin('users as us','us.id','=','po.user_id')
        ->leftJoin('institutes as inst','inst.id','=','us.preferred_institute_id');
        // ->leftJoin('likes as li2', function($join){
        //     $join->on('li2.likable_id','=','po.id')->where('li2.likable_type','=','App\Models\Post');
        // });
        $columns = ['po.id as id','po.post_heading as heading','po.post_description as description','po.postable_type as postable_type','cat.name as category_name','cat.id as category_id','po.primary_image_path as image_path',
        'us.avatar_url as profile_image','us.id as user_id','us.full_name as user_name','inst.name as institute_name','ar.html_content as article_content',
        'vd.video_id as video_id'];
        $groupBycolumns = ['po.id','po.post_heading','po.post_description','po.postable_type','cat.name','cat.id','po.primary_image_path',
        'us.avatar_url','us.id','us.full_name','inst.name','ar.html_content',
        'vd.video_id'];

        if(Auth::check()){
            $post_query->leftJoin('likes as uli',function($join){
                $join->on('po.id','=','uli.likable_id')->where('uli.likable_type','=','App\Models\Post')->where('uli.user_id','=',Auth::user()->id);
            });
            array_push($columns,'uli.like_status as user_like');
            array_push($groupBycolumns,'uli.like_status');
        }

        return $post_query->select($columns)
        ->groupBy($groupBycolumns);
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
        }
    }

    public function formatPostData($posts){
        // $path =  (dirname(__FILE__) .'./Services/simple_html_dom.php');
        // require($path);
           //get groupBy fields
           foreach($posts as $post){
            $rand=rand(60,100);
            $postData=PostModel::where('id',$post->id)
            ->with('subjects')
            ->withCount('likes','comments')
            ->first();
            
            $post->description=strlen($post->description)>$rand ? substr($post->description,0,$rand).'...' : $post->description;
            $post->post_type=$this->getPostType($post->postable_type);
            $post->subjects=$postData->subjects;
            // $post->count = DB::table('comments')->where('commentable_id','=',$post->id)->count(DB::raw('DISTINCT user_id'));
            // $post->total_reactions=($postData->likes_count+$post->count);
            $post->profile_image=$post->profile_image ?? '';
            $post->image_path=$post->image_path ?? '';
            $post->total_likes=$postData->likes_count;
            $post->total_reactions = DB::table('sthub_posts as st')->where('st.post_id','=',$post->id)
            ->where('action_type','!=','share')->where('action_type','!=','view')
            ->leftjoin('users as us', 'us.id','=','st.action_user_id')
            ->count();
      
            
        }

        return $posts;
    }

    public function getExplorePagePosts($type){
        $posts=DB::table('explore_page_posts as epp')->where('epp.page_section',$type)
        ->leftJoin('posts as po','po.id','=','epp.post_id')
        ->leftJoin('articles as ar',function($join){
            $join->on('po.postable_id','=','ar.id')->where('po.postable_type','=','App\Models\Article');
        })
        ->leftJoin('videos as vd',function($join){
            $join->on('po.postable_id','=','vd.id')->where('po.postable_type','=','App\Models\Video');
        })
        ->leftJoin('categories as cat','cat.id','=','po.category_id')
        ->leftJoin('users as us','us.id','=','po.user_id')
        // ->leftJoin('facts as fa','po.id','=','fa.post_id')
        ->select(['po.id as id','po.post_heading as heading','po.post_description as description','po.postable_type as postable_type','cat.name as category_name','cat.id as category_id','po.primary_image_path as image_path',
        'po.created_at as time','us.avatar_url as profile_image','us.full_name as user_name','ar.html_content as article_content',
        'vd.video_id as video_id'])->limit(3)->get();

        return $this->formatPostData($posts);
    }

    public function getAuthPostContent($post_id){
        $post=DB::table('posts as po')->where('po.id','=',$post_id)
        ->leftJoin('articles as ar',function($join){
            $join->on('po.postable_id','=','ar.id')->where('po.postable_type','=','App\Models\Article');
        })
        ->leftJoin('videos as vd',function($join){
            $join->on('po.postable_id','=','vd.id')->where('po.postable_type','=','App\Models\Video');
        })
        ->leftJoin('facts as fc',function($join){
            $join->on('po.postable_id','=','fc.id')->where('po.postable_type','=','App\Models\Fact');
        })
        ->leftJoin('documents as do',function($join){
            $join->on('po.postable_id','=','do.id')->where('po.postable_type','=','App\Models\Document');
        })
        ->leftJoin('likes as uli',function($join){
            $join->on('po.id','=','uli.likable_id')->where('uli.likable_type','=','App\Models\Post')->where('uli.user_id','=',Auth::user()->id);
        })
        ->leftJoin('categories as cat','cat.id','=','po.category_id')
        ->leftJoin('users as us','us.id','=','po.user_id')
        // ->leftJoin('facts as fa','po.id','=','fa.post_id')
        ->select(['po.id as id','po.post_heading as heading','po.post_description as description','po.post_description as content','po.postable_type as postable_type','cat.name as category_name','cat.id as category_id','po.primary_image_path as image_path',
        'po.created_at as time','us.avatar_url as profile_image','us.full_name as user_name','ar.html_content as article_content','uli.like_status as user_like',
        'vd.video_id as video_id','fc.image_path as fact_image_path','do.link as document_link'
        ])->get();

        return $this->formatPostData($post);
    }
    public function getGuestPostContent($post_id){
        $post=DB::table('posts as po')->where('po.id','=',$post_id)
        ->leftJoin('articles as ar',function($join){
            $join->on('po.postable_id','=','ar.id')->where('po.postable_type','=','App\Models\Article');
        })
        ->leftJoin('videos as vd',function($join){
            $join->on('po.postable_id','=','vd.id')->where('po.postable_type','=','App\Models\Video');
        })
        ->leftJoin('facts as fc',function($join){
            $join->on('po.postable_id','=','fc.id')->where('po.postable_type','=','App\Models\Fact');
        })
        ->leftJoin('documents as do',function($join){
            $join->on('po.postable_id','=','do.id')->where('po.postable_type','=','App\Models\Document');
        })
        ->leftJoin('categories as cat','cat.id','=','po.category_id')
        ->leftJoin('users as us','us.id','=','po.user_id')
        // ->leftJoin('facts as fa','po.id','=','fa.post_id')
        ->select(['po.id as id','po.post_heading as heading','po.post_description as description','po.postable_type as postable_type','cat.name as category_name','cat.id as category_id','po.primary_image_path as image_path',
        'po.created_at as time','us.avatar_url as profile_image','us.full_name as user_name','ar.html_content as article_content',
        'vd.video_id as video_id','fc.image_path as fact_image_path','do.link as document_link'])->get();

        return $this->formatPostData($post);
    }

    public function getMostViewedPosts($category_id){
        $post_query=$this->getAuthUserPostTabels();

        $posts=$post_query->where('cat.id',$category_id)
        ->limit(3)->get();

        return $this->formatPostData($posts);
    }

    public function getMostLikedPosts($category_id){
        $post_query=$this->getAuthUserPostTabels();

        $posts=$post_query->where('cat.id',$category_id)
        ->limit(3)->get();

        return $this->formatPostData($posts);
    }
}
