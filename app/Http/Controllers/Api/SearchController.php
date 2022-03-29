<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

class SearchController extends Controller
{
    
    public function searchUser(Request $request){
        if(empty($request->searchTerm) || empty($request->role)){
            return response()->json([
                'success'=>[
                    'users'=>[],
                ]
            ]);
        }
        $users = DB::table('users as us')->where('us.full_name', 'LIKE', $request->searchTerm.'%')
        ->where('role', $request->role)
            ->leftJoin('institutes as inst', 'inst.id', '=', 'us.preferred_institute_id')
            ->leftJoin('courses as cor', 'cor.id', '=', 'us.preferred_course_id')
            ->select(
                'us.full_name',
                'us.avatar_url',
                'inst.name as institute_name',
                'cor.course_name',
            )
            ->groupBy('us.id','us.full_name','us.avatar_url','inst.name')
            ->limit(10)->get();

            return response()->json([
                'success'=>[
                    'users'=>$users,
                ]
            ]);
    }

    public function searchPosts(Request $request){
        if(empty($request->searchTerm)){
            return response()->json([
                'success'=>[
                    'posts'=>[],
                ]
            ]);
        }
        $post=new \App\Post;
        $posts = $post->getSearchPosts($request);

        return response()->json(['success'=>[
        'posts'=>\Sthub::convert_from_latin1_to_utf8_recursively($posts)
        ]]);
    }
}
