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
                
            // Create DOM from URL or file
            $html = str_get_html($postContent['content']);
            $files=[];
            foreach($html->find('img') as $element){
                $base64_image=$element->src;
                if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
                    $data = substr($base64_image, strpos($base64_image, ',') + 1);
                
                    $data = base64_decode($data);
                    $file_name=uniqid();
                    \Storage::disk('local')->put("post-images/".$file_name, $data);

                    $files[]=$file_name;
                    $element->src="/post-images/".$file_name;
                }
            }
            
            $post_content_id=Article::create(['content'=>$html])->id;
            $post->postable_type="App\Models\Article";
            $post->postable_id=$post_content_id;
            foreach($files as $file){
                $newFile= new SthubFile();
                    $newFile->fileable_id=$post_content_id;
                    $newFile->fileable_type='App\Models\Article';
                    $newFile->file_ext='png';
                    $newFile->file_size=20;
                    $newFile->file_name=$file;
                    $newFile->user_id=Auth::user()->id;
                    $newFile->save();
            }
            break;
            case 'notice':
            break;
            case 'document':
                $document=Document::create([
                    'total_files'=>1,
                ]);
                $newPost=$request->newPost;
                foreach($newPost->files as $file){
                    if($file->fileObject===true){
                        $newFile= new File();
                        $newFile->fileable_id=$document->id;
                        $newFile->fileable_type='App\Models\Document';
                        $newFile->file_ext=$file->type;
                        $newFile->file_size=$file->size;
                        $newFile->file_name=$file->name;
                        $newFile->user_id=Auth::user()->id;
                    }
                }
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
            $post->postable_type="App\Models\Article";
            $post->postable_id=$post_content_id;
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

    public function getStudentPosts(){
        // $posts=DB::table('sthub_posts as sp')
        // ->leftJoin('posts as po','po.id','=','sp.post_id')
        // // ->leftJoin('articles as ar','po.id','=','ar.post_id')
        // // ->leftJoin('documents as do','po.id','=','do.post_id')
        // ->join('videos as vd',function($join){
        //     $join->on('po.postable_id','=','vd.id')->where('po.postable_type','=','App\Models\Video');
        // })
        // // ->leftJoin('notices as no','po.id','=','no.post_id')
        // // ->leftJoin('facts as fa','po.id','=','fa.post_id')
        // // ->leftJoin('mcqs as mc','po.id','=','mc.post_id')
        // ->leftJoin('likes as li','po.id','=','li.post_id')
        // ->leftJoin('views as vw','po.id','=','vw.post_id')
        // ->select(['po.id as id','vd.*',DB::raw('COUNT(distinct li.user_id) as total_likes'),DB::raw('COUNT(distinct vw.user_id) as total_views')])
        // ->groupBy(['sp.post_id','vd.id','vd.link','vd.content'])
        // ->paginate();
        
        // use Illuminate\Pagination\LengthAwarePaginator as Paginator;

// $page       = ($request->input('page') != null) ? $request->input('page') : 1;
// $perPage    = 1;

// $sliced     = array_slice($data, 0, 5); //you can these values as per your requirement 

// $paginator  = new Paginator($sliced, count($data), $perPage, $page,['path'  => url()->current(),'query' => $request->query()]);

// return $paginator;
        $posts=SthubPost::getDashboardPosts();
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }

    public function getSeekerDashboard(Request $request){
        $data=DB::table('sthub_posts as sp')
        ->join('posts as po','po.id','=','sp.post_id')
        ->join('videos as vd',function($join){
            $join->on('po.postable_id','=','vd.id')->where('postable_type','=','App\Models\Video');
        })
        // ->leftJoin('videos as vd','po.id','=','vd.post_id')
        // ->leftJoin('facts as fa','po.id','=','fa.post_id')
        ->leftJoin('likes as li','po.id','=','li.post_id')
        ->leftJoin('views as vw','po.id','=','vw.post_id')
        ->select(['po.id as id','vd.*',DB::raw('COUNT(distinct li.user_id) as total_likes'),DB::raw('COUNT(distinct vw.user_id) as total_views')])->groupBy('sp.post_id','vd.*')->get();
        // ,'do.*','vd.*','fa.*','no.*','mc.*'

$page       = ($request->input('page') != null) ? $request->input('page') : 1;
$perPage    = 1;

$sliced     = array_slice($data, 0, 5); //you can these values as per your requirement 

$paginator  = new Paginator($sliced, count($data), $perPage, $page,['path'  => url()->current(),'query' => $request->query()]);

        return response()->json(['success'=>[
            'posts'=>$paginator
        ]]);
    }
}
