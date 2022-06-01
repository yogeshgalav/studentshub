<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SubjectController extends Controller
{
    //

    public function index(Request $request)
    {
        $me_id = $request->user('api')->id;
        $subject_query = DB::table('subjects as sub');
        if(!empty($request->searchTerm)){
            $search = str_replace('.', '', $request->searchTerm);
            $subject_query = $subject_query->where('sub.subject_name', 'LIKE', '%' . $search . '%')
            ->orWhere('sub.alias', 'LIKE', $search);
        }
        if(!empty($request->categoryId)){
            $subject_query=$subject_query->where('category_id','=',$request->categoryId);
        }
        $subjects=$subject_query
        ->leftJoin('votes as my_vote',function($join)use($me_id){
          $join->on('sub.id','=','my_vote.subject_id')->where('my_vote.user_id','=',$me_id);
        })
        ->leftJoin('votes as total_upvote',function($join){
            $join->on('sub.id','=','total_upvote.subject_id')->where('total_upvote.status','=',1);
        })
          ->leftJoin('votes as total_downvote',function($join){
            $join->on('sub.id','=','total_downvote.subject_id')->where('total_downvote.status','=',0);
        })
        ->select('sub.subject_name',DB::raw('COUNT(DISTINCT total_upvote.id) as total_upvotes'),
        DB::raw('COUNT(DISTINCT total_downvote.id) as total_downvotes'), 'my_vote.status as myvote')
        ->groupBy('sub.subject_name', 'my_vote.status')
            ->limit(10)->get();
            
        return response()->json(['success' => [
            'subjects' => $subjects
        ]]);
    }

    public function show(Request $request){
        $subject=\App\Models\Subject::where('slug', $request->route('id'))->firstOrFail();

        return response()->json(['success'=>[
            'subject'=>$subject,
        ]]);
      }


}
