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

        $answer = new DoubtAnswer();
        $answer->user_id = Auth::id();
        $answer->doubt_id = $doubtId;
        $answer->answer = $request->answer_html;

        $post=new Post;
        $post->user_id=Auth::user()->id;
        $post->post_heading=$doubt->question;
        $post->subject_id=$doubt->subject_id;

        $article=new Article;
        $post_content_id=$article->createFromContent([
            'article_html_content'=>$request->answer_html,
            ]);
        $post->post_description=$request->answer_text;
        $post->postable_type="App\Models\Article";
        $post->primary_image_path='/storage/article-default.png';
        $post->postable_id=$post_content_id;
        $post->category_id=$doubt->course->category_id;
        $post->course_id=$doubt->course_id;
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
        return 'success';
    }

    public function getDoubtanswers($doubtId,Request $request)
    {
        $doubt=\DB::table('doubts')->where('doubts.id',$doubtId)
        ->join('users as us','us.id','=','doubts.user_id')
        ->join('institutes as inst','inst.id','=','us.preferred_institute_id')
        ->join('categories as cat','cat.id','=','doubts.category_id')
        ->select('us.full_name as user_name','us.avatar_url as profile_image','cat.name','inst.name as inst_name',
        'doubts.question','doubts.created_at','doubts.id')
        ->first();
        $doubt->time=\Carbon\Carbon::createFromTimeStamp(strtotime($doubt->created_at))->diffForHumans();

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
