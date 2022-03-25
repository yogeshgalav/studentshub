<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Doubt;
use App\Models\DoubtAnswer;
use App\Models\Post;
use App\Models\Article;
use App\Models\SthubPost;
use Illuminate\Http\Request;
use Auth;
use Arr;
use DB;
use Illuminate\Support\Facades\Log;

class DoubtAnswersController extends Controller
{

    public function addDoubtAnswer(Doubt $doubt,Request $request)
    {

        DB::beginTransaction();
    try{

        $me = $request->user('api');
        $answer = new DoubtAnswer();
        $answer->user_id = $me->id;
        $answer->doubt_id = $doubt->id;
        $answer->answer = $request->answer_html;

        $post=new Post;
        $post->user_id=$me->id;
        $post->post_heading=$doubt->question;
        $post->post_description=$request->answer_text;
        $post->category_id=$doubt->category_id;
        $post->course_id=$me->preferred_course_id;


        $simple_html_dom = new simple_html_dom;
        $dom = $simple_html_dom->extactImageFiles($data['article_html_content'], "post-image");
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
          $primary_image_path= $simple_html_dom->extractYoutubeImage($data['article_html_content']);
        }

        $post->postable_type="App\Models\Article";
        $post->primary_image_path=$primary_image_path;
        $post->postable_id=$post_content->id;

        $post->created_via='doubt';
        $post->save();

        $answer->post_id=$post->id;
        $answer->save();
        $doubt->copyTags($post);
        SthubPost::addAction('share',$post,Auth::user());

    DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Doubt Answer Creation failure',['data'=>$request->all(),'error'=>$e->getMessage()]);
            // dd($e->getMessage(),$e->getLine());
            return response()->$e;
        }
        return response()->json([
            'success'=>[
                'post_id'=>$post->id
            ]
        ]);
    }

    public function getDoubtanswers(Doubt $doubt,Request $request)
    {
        $doubt_details=Doubt::where('doubts.id',$doubt->id)
        ->join('users as us','us.id','=','doubts.user_id')
        ->leftJoin('institutes as inst','inst.id','=','us.preferred_institute_id')
        ->join('categories as cat','cat.id','=','doubts.category_id')
        ->select('us.full_name as user_name','us.avatar_url as profile_image','cat.name as category_name','inst.name as inst_name',
        'doubts.question','doubts.created_at','doubts.id')
        ->with('subjects')
        ->first();

        $post = new \App\Post;
        $answers=$post->getDoubtPosts($doubt->id);

        return response()->json([
            'success'=>[
                'doubt'=>$doubt_details,
                'answerList'=>$answers,
                'isAnswered'=>DoubtAnswer::where('doubt_id',$doubt->id)->where('user_id',Auth::id())->exists()
            ]
        ]);
    }
}
