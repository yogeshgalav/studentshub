<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostContent;
use App\Models\Article;
use Auth;

class ExploreController extends Controller
{
    public function index(){
        $poosts=ViewPost::whereIn('type',['article','fact','video'])->get();
    }
}
