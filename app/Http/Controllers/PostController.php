<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SthubPost;
use App\Models\PostContent;
use App\Models\PostImage;
use App\Models\Article;
use App\Models\Subject;
use App\Models\Video;
use Auth;
use DB;
use Illuminate\Support\Arr;

class PostController extends Controller
{
    //
    public function create(Request $request){
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
        $post->post_type=$post_type;
        $post->post_heading=$heading;
        $post->subject_id=$subject->id;
        $post->save();

        switch(strToLower($request->post_type)){
            case 'article':
            $post_content_id=Article::create(['post_id'=>$post->id,'content'=>$postContent['content']])->id;
            break;
            case 'notice':
            break;
            case 'document':
                $document=Document::create([
                    'post_id'=>$post->id,
                    'total_files'=>1,
                ]);
                $newPost=$request->newPost;
                foreach($newPost->files as $file){
                    if($file->fileObject===true){
                        $newFile= new File();
                // $filename = Str::slug($conversationInstance->title).'-commitment-instruction-'.Carbon::now()->toDateString().'.pdf';
                // $file = Storage::disk('local')->put($filename);
                        $newFile->fileable_id=$document->id;
                        $newFile->fileable_type='App\Document';
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
            // if ($pos=strpos($str, 'watch?v=') == true) {
            //     $video_id=str_replace('https://www.youtube.com/watch?v=','',$str);
            // }else if ($pos=strpos($str, 'youtu.be/') == true) {
            //     $video_id=str_replace('https://www.youtu.be/','',$str);
            // }
            $post_content_id=Video::insertGetId(['post_id'=>$post->id,
            'link'=>'https://www.youtube.com/embed/'.$video_id,
            'description'=>$postContent['description'] ?? null
            ]);
            $post_image=PostImage::create(['post_id'=>$post->id,
            'user_id'=>Auth::user()->id,
            'path'=>'https://img.youtube.com/vi/'.$video_id.'/0.jpg'
            ]);
            break;
        }
        SthubPost::create([
            'post_id'=>$post->id,
            'post_type'=>$post_type,
            // 'post_content_id'=>$post_content_id,
            'shared_by'=>Auth::user()->id,
        ]);
        
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::critical('Post Creation failure: for user id#'.Auth::user()->id.' with data '.implode(', ',Arr::flatten($data)));
        // dd($e->getMessage(),$e->getLine());
        return response()->$e;
    }
        return response()->json('success');
    }
}
