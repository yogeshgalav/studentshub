<?php

namespace App\Http\Controllers;
use App\Models\Doubt;
use App\Models\DoubtAnswer;
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
        $answer->answer = $request->answer;
        $answer->save();

        $post=new Post;
        $post->user_id=Auth::user()->id;
        $post->post_heading=$doubt->question;
        $post->subject_id=$doubt->subject_id;

        $article=new Article;
        $post_content_id=$article->createFromContent(['article_html_content'=>$request->answer]);
        $post->postable_type="App\Models\Article";
        $post->primary_image_path='/storage/article-default.png';
        $post->postable_id=$post_content_id;

        $post->save();
        $student = Auth::student();
        SthubPost::create([
            'post_id'=>$post->id,
            'institute_id'=>$student->instituteId,
            'course_id'=>$student->courseId,
            'shared_by'=>Auth::id(),
        ]);

    DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Doubt Creation failure: for user id#'.Auth::user()->id.' with data '.implode(', ',Arr::flatten($input)));
            // dd($e->getMessage(),$e->getLine());
            return response()->$e;
        }
        return 'success';
    }

    public function getDoubtanswers($doubtId,Request $request)
    {
        $answers=\DB::table('doubt_answers as da')->where('da.doubt_id',$doubtId)
        ->join('posts','posts.id','=','da.post_id')
        ->get();

        return response()->json([
            'success'=>[
                'answerList'=>$answers
            ]
        ]);
    }

    public function getDoubtAnswersPage(){
        return view('doubt.answer');
    }
}
