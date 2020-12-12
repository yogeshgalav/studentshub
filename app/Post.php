<?php

namespace App;

use App\Models\Post as PostModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;
use PHPHtmlParser\Dom;

class Post extends PostModel
{
    protected $student;

    public function __construct(){
        $this->student=Auth::student();
    }

    public function getSubjectPosts(Request $request){
        if($this->student){
            $post_query=$this->getStudentPostTables();
        }else{
            $post_query=$this->getSeekerPostTabels();     
        }

        $posts=$post_query->where('sub.subject_url',$request->route('subjectUrl'))
        ->orderBy('po.created_at','DESC')
        ->paginate();

        $this->formatPostData($posts);
        
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }

    public function getCategoryPosts(Request $request){
        if($this->student){
            $post_query=$this->getStudentPostTables();
        }else{
            $post_query=$this->getSeekerPostTabels();     
        }

        $posts=$post_query->where('cat.category_url',$request->route('categoryUrl'))
        ->orderBy('po.created_at','DESC')
        ->paginate();

        $this->formatPostData($posts);
        
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }
    public function getCoursePosts(Request $request){
        if($this->student){
            $post_query=$this->getStudentPostTables();
        }else{
            $post_query=$this->getSeekerPostTabels();     
        }

        $posts=$post_query->where('course.id',$request->route('courseUrl'))
        ->orderBy('po.created_at','DESC')
        ->paginate();

        $this->formatPostData($posts);
        
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }
    public function getSearchPosts(Request $request){
        if($this->student){
            $post_query=$this->getStudentPostTables();
        }else{
            $post_query=$this->getSeekerPostTabels();     
        }

        $posts=$post_query->where('sub.subject_name','LIKE','%'.$request->input('query').'%')
        ->orWhere('cat.name','LIKE','%'.$request->input('query').'%')
        ->orWhere('po.post_heading','LIKE','%'.$request->input('query').'%')
        ->orderBy('po.created_at','DESC')
        ->paginate();

        $this->formatPostData($posts);
        
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }

    public function getStudentPosts(Request $request){
        
        $posts=$this->getStudentPostTables()
        ->orderBy('po.created_at','DESC')
        ->paginate();

        $this->formatPostData($posts);
        
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }

    public function getStudentPostTables(){
        $myInstituteId=$this->student->instituteId;
        $myCourseId=$this->student->courseId;

        return DB::table('sthub_posts as sp')
        ->join('posts as po','po.id','=','sp.post_id')
        ->leftJoin('articles as ar',function($join){
            $join->on('po.postable_id','=','ar.id')->where('po.postable_type','=','App\Models\Article');
        })
        ->leftJoin('videos as vd',function($join){
            $join->on('po.postable_id','=','vd.id')->where('po.postable_type','=','App\Models\Video');
        })
        ->leftJoin('likes as uli',function($join){
            $join->on('po.id','=','uli.likable_id')->where('uli.likable_type','=','App\Models\Post')->where('uli.user_id','=',Auth::user()->id);
        })
        ->leftJoin('subjects as sub','sub.id','=','po.subject_id')
        ->leftJoin('categories as cat','cat.id','=','sub.category_id')
        ->leftJoin('users as us','us.id','=','po.user_id')
        ->leftJoin('institutes as inst','inst.id','=','sp.institute_id')
        ->leftJoin('courses as course','course.id','=','sp.course_id')
        
        // ->leftJoin('documents as do',function($join)use($myInstituteId,$myCourseId){
        //     $join->on('po.postable_id','=','do.id')->where('po.postable_type','=','App\Models\Document')
        //     ->where('inst.id','=',$myInstituteId)->where('course.id','=',$myCourseId);
        // })
        // ->leftJoin('notices as no',function($join)use($myInstituteId){
        //     $join->on('po.postable_id','=','no.id')->where('po.postable_type','=','App\Models\Notice')
        //     ->where('inst.id','=',$myInstituteId);
        // })
        ->leftJoin('facts as fc',function($join){
            $join->on('po.postable_id','=','fc.id')->where('po.postable_type','=','App\Models\Fact');
        })
        ->leftJoin('mcqs',function($join){
            $join->on('po.postable_id','=','mcqs.id')->where('po.postable_type','=','App\Models\Mcq');
        })
        ->select(['po.id as id','po.post_heading as heading','po.post_description as description','po.postable_type as postable_type','cat.name as category_name','cat.id as category_id','po.primary_image_path as image_path',
        'sub.subject_url','sub.subject_name','course.id as course_id','course.course_name','uli.like_status as user_like',
        'po.created_at as time','us.avatar_url as profile_image','us.full_name as user_name','inst.name as institute_name','ar.html_content as article_content',
        'vd.video_id as video_id','fc.image_path as fact_image_path','mcqs.optionA','mcqs.optionB','mcqs.optionC','mcqs.optionD']);
    }

    public function getSeekerPosts(Request $request){

        $posts=$this->getSeekerPostTabels()
        ->orderBy('po.created_at','DESC')
        ->paginate();

        $this->formatPostData($posts);
        
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }

    public function getSeekerPostTabels(){
        return DB::table('sthub_posts as sp')
        ->join('posts as po','po.id','=','sp.post_id')
        ->leftJoin('articles as ar',function($join){
            $join->on('po.postable_id','=','ar.id')->where('po.postable_type','=','App\Models\Article');
        })
        ->leftJoin('videos as vd',function($join){
            $join->on('po.postable_id','=','vd.id')->where('po.postable_type','=','App\Models\Video');
        })
        ->leftJoin('facts as fc',function($join){
            $join->on('po.postable_id','=','fc.id')->where('po.postable_type','=','App\Models\Fact');
        })
        ->leftJoin('mcqs',function($join){
            $join->on('po.postable_id','=','mcqs.id')->where('po.postable_type','=','App\Models\Mcq');
        })
        ->leftJoin('subjects as sub','sub.id','=','po.subject_id')
        ->leftJoin('categories as cat','cat.id','=','sub.category_id')
        ->leftJoin('users as us','us.id','=','po.user_id')
        ->leftJoin('institutes as inst','inst.id','=','sp.institute_id')
        ->leftJoin('courses as course','course.id','=','sp.course_id')
        // ->leftJoin('facts as fa','po.id','=','fa.post_id')
        ->select(['po.id as id','po.post_heading as heading','po.post_description as description','po.postable_type as postable_type','cat.name as category_name','cat.id as category_id','po.primary_image_path as image_path',
        'sub.subject_url','sub.subject_name','course.id as course_id','course.course_name',
        'po.created_at as time','us.avatar_url as profile_image','us.full_name as user_name','ar.html_content as article_content',
        'vd.video_id as video_id','fc.image_path as fact_image_path','mcqs.optionA','mcqs.optionB','mcqs.optionC','mcqs.optionD']);
    }

    public function getPostType($post_type){
        switch($post_type){
            case 'App\Models\Article':
                return 'article';
            case 'App\Models\Video':
                return 'video';
            case 'App\Models\Fact':
                return 'fact';
            // case 'App\Models\Document':
            //     return 'document';
            // case 'App\Models\Notice':
            //     return 'notice';
            case 'App\Models\Mcq':
                return 'mcq';
        }
    }

    public function formatPostData($posts){
        // $path =  (dirname(__FILE__) .'./Services/simple_html_dom.php');
        // require($path);
           //get groupBy fields
           foreach($posts as $post){
            $rand=rand(60,100);
            $postData=DB::table('posts as po')->where('po.id',$post->id)
            ->leftJoin('likes as li',function($join){
                $join->on('po.id','=','li.likable_id')->where('li.likable_type','=','App\Models\Post')->where('li.like_status','=',1);
            })
            ->leftJoin('likes as dli',function($join){
                $join->on('po.id','=','dli.likable_id')->where('dli.likable_type','=','App\Models\Post')->where('dli.like_status','=',0);
            })
            ->leftJoin('post_views as vw','po.id','=','vw.post_id')
            ->select(DB::raw('COUNT(distinct li.user_id) as total_likes'),DB::raw('COUNT(distinct dli.user_id) as total_dislikes'),DB::raw('COUNT(distinct vw.user_id) as total_views'))
            ->groupBy(['po.id'])
            ->first();

            $post->description=strlen($post->description)>$rand ? substr($post->description,0,$rand).'...' : $post->description;
            $post->post_type=$this->getPostType($post->postable_type);
            $post->total_likes=$postData->total_likes;
            $post->total_dislikes=$postData->total_dislikes;
            $post->total_views=$postData->total_views;
            $post->profile_image=$post->profile_image ?? '';
            $post->image_path=$post->image_path ?? '';
            $post->time=Carbon::createFromTimeStamp(strtotime($post->time))->diffForHumans();
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
        ->leftJoin('subjects as sub','sub.id','=','po.subject_id')
        ->leftJoin('categories as cat','cat.id','=','sub.category_id')
        ->leftJoin('users as us','us.id','=','po.user_id')
        // ->leftJoin('facts as fa','po.id','=','fa.post_id')
        ->select(['po.id as id','po.post_heading as heading','po.post_description as description','po.postable_type as postable_type','cat.name as category_name','cat.id as category_id','sub.subject_name','po.primary_image_path as image_path',
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
        ->leftJoin('mcqs',function($join){
            $join->on('po.postable_id','=','mcqs.id')->where('po.postable_type','=','App\Models\Mcq');
        })
        ->leftJoin('likes as uli',function($join){
            $join->on('po.id','=','uli.likable_id')->where('uli.likable_type','=','App\Models\Post')->where('uli.user_id','=',Auth::user()->id);
        })
        ->leftJoin('subjects as sub','sub.id','=','po.subject_id')
        ->leftJoin('categories as cat','cat.id','=','sub.category_id')
        ->leftJoin('users as us','us.id','=','po.user_id')
        // ->leftJoin('facts as fa','po.id','=','fa.post_id')
        ->select(['po.id as id','po.post_heading as heading','po.post_description as description','po.postable_type as postable_type','cat.name as category_name','cat.id as category_id','sub.subject_name','po.primary_image_path as image_path',
        'po.created_at as time','us.avatar_url as profile_image','us.full_name as user_name','ar.content as article_content','uli.like_status as user_like',
        'vd.video_id as video_id','fc.image_path as fact_image_path','mcqs.optionA','mcqs.optionB','mcqs.optionC','mcqs.optionD',
        'mcqs.correct_option','mcqs.answer as mcq_answer'])->get();

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
        ->leftJoin('mcqs',function($join){
            $join->on('po.postable_id','=','mcqs.id')->where('po.postable_type','=','App\Models\Mcq');
        })
        ->leftJoin('subjects as sub','sub.id','=','po.subject_id')
        ->leftJoin('categories as cat','cat.id','=','sub.category_id')
        ->leftJoin('users as us','us.id','=','po.user_id')
        // ->leftJoin('facts as fa','po.id','=','fa.post_id')
        ->select(['po.id as id','po.post_heading as heading','po.post_description as description','po.postable_type as postable_type','cat.name as category_name','cat.id as category_id','sub.subject_name','po.primary_image_path as image_path',
        'po.created_at as time','us.avatar_url as profile_image','us.full_name as user_name','ar.html_content as article_content',
        'vd.video_id as video_id','fc.image_path as fact_image_path','mcqs.optionA','mcqs.optionB','mcqs.optionC','mcqs.optionD'])->get();

        return $this->formatPostData($post);
    }

    public function getMostViewedPosts($category_id){
        if($this->student){
            $post_query=$this->getStudentPostTables();
        }else{
            $post_query=$this->getSeekerPostTabels();     
        }

        $posts=$post_query->where('cat.id',$category_id)
        ->limit(3)->get();

        return $this->formatPostData($posts);
    }

    public function getMostLikedPosts($category_id){
        if($this->student){
            $post_query=$this->getStudentPostTables();
        }else{
            $post_query=$this->getSeekerPostTabels();     
        }

        $posts=$post_query->where('cat.id',$category_id)
        ->limit(3)->get();

        return $this->formatPostData($posts);
    }
}