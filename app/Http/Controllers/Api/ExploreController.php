<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Post;
use App\Models\Guest;
use App\Models\Category;
use Auth;

class ExploreController extends Controller
{
    public function index(Request $request){
        $guest=new Guest();
        $guest->add($request);
        $post = new Post;
        return response()->json(['success'=>[
            'categories'=>Category::where('slug','!=',null)->get(),
            'ExploreTopPost'=>$post->getExplorePagePosts('ExploreTopPost'),
            'HomePostContainer'=>$post->getExplorePagePosts('HomePostContainer'),
            'ExploreSidebar'=>$post->getExplorePagePosts('ExploreSidebar'),
            'ExploreBottomPost'=>$post->getExplorePagePosts('ExploreBottomPost'),
        ]]); 
    }
}
