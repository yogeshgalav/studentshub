<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;

class UserController extends Controller
{
    //
    public function getInterests(){
        if(is_null(Auth::student())){
            return response()->json(['success'=>[
                'interests'=>[]
            ]]);
        }

        $categories=DB::table('categories as cat')->leftJoin('subjects as sub','sub.category_id','=','cat.id')
        ->leftJoin('posts as po','po.subject_id','=','sub.id')
        ->leftJoin('post_views as pv',function($join){
            $join->on('pv.post_id','=','po.id')->where('pv.user_id','=',Auth::id());
        })
        ->leftJoin('likes as li',function($join){
            $join->on('po.id','=','li.likable_id')->where('li.likable_type','=','App\Models\Post')->where('li.user_id','=',Auth::id());
        })
        ->leftJoin('posts as upo',function($join){
            $join->on('upo.subject_id','=','sub.id')->where('upo.user_id','=',Auth::id());
        })
        ->select(DB::raw('COUNT(distinct li.likable_id) as total_likes'),DB::raw('COUNT(distinct pv.post_id) as total_views'),DB::raw('COUNT(distinct upo.id) as total_posts'))
        ->groupBy('cat.id')
        ->get();
        
        $total=0;
        foreach($categories as $category){
            $category->total=$category->total_views+($category->total_likes*3)+($category->total_posts*7);
            $total += $category->total;
        }
        foreach($categories as $category){
            $category->percent=($category->total/$total)*100;
        }
        return response()->json(['success'=>[
            'interests'=>$categories
        ]]);
    }
}
