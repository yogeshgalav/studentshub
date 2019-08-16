<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ViewPost;
use App\Models\Article;
use App\Models\Subject;
use Auth;

class ExploreController extends Controller
{
    public function index(){
        $posts=ViewPost::whereIn('post_type',['article','fact','video'])->get();
        $categories=Subject::getAllCategories();
        return response()->json(['success'=>[
            'categories'=>$categories,
            'Carousel'=>$posts,
            'ExploreTopPost'=>$posts,
            'HomePostContainer'=>$posts,
            'ExploreSidebar'=>$posts,
            'ExploreBottomPost'=>$posts,
        ]]); 
    }
}
