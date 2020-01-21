<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SthubPost;
use App\Models\PostContent;
use App\Models\Article;
use Auth;

class HomeController extends Controller
{

    public function index(){
        $posts=SthubPost::getDashboardPosts();
        return response()->json(['success'=>[
            'posts'=>$posts
        ]]);
    }

}
