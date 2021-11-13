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

    public function addDoubtAnswer ($doubtId,Request $request)
    {

        $doubt = Doubt::findOrFail($doubtId);
        DB::beginTransaction();
    try{

        $me = $request->user('api');
        $answer = new DoubtAnswer();
        $answer->user_id = $me->id;
        $answer->doubt_id = $doubtId;
        $answer->answer = $request->answer_html;

        $post=new Post;
        $post->user_id=$me->id;
        $post->post_heading=$doubt->question;

        $article=new Article;
        $post_content_id=$article->createFromContent([
            'article_html_content'=>$request->answer_html,
            ]);
        $post->post_description=$request->answer_text;
        $post->postable_type="App\Models\Article";
        $post->primary_image_path='/storage/article-default.png';
        $post->postable_id=$post_content_id;
        $post->category_id=$doubt->category_id;
        $post->course_id=$me->preferred_course_id;
        $post->created_via='doubt';
        $post->save();

        $answer->post_id=$post->id;
        $answer->save();
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

    public function getDoubtanswers($doubtId,Request $request)
    {
        $doubt=Doubt::where('doubts.id',$doubtId)
        ->join('users as us','us.id','=','doubts.user_id')
        ->join('institutes as inst','inst.id','=','us.preferred_institute_id')
        ->join('categories as cat','cat.id','=','doubts.category_id')
        ->select('us.full_name as user_name','us.avatar_url as profile_image','cat.name as category_name','inst.name as inst_name',
        'doubts.question','doubts.created_at','doubts.id')
        ->with('subjects')
        ->first();

        $post = new \App\Post;
        $answers=$post->getDoubtPosts($doubtId);

        return response()->json([
            'success'=>[
                'doubt'=>$doubt,
                'answerList'=>$answers,
                'isAnswered'=>DoubtAnswer::where('doubt_id',$doubtId)->where('user_id',Auth::id())->exists()
            ]
        ]);
    }
}
