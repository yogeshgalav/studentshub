<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SthubPost;
use App\Models\ExplorePagePost;
use App\Models\Article;
use App\Models\Category;
use App\Models\Guest;
use Auth;

class ExploreController extends Controller
{
    public function index(Request $request){
        $guest=new Guest();
        $guest->add($request);

        return response()->json(['success'=>[
            'categories'=>Category::all(),
            'ExploreCarousalPost'=>ExplorePagePost::getPostType('ExploreCarousalPost'),
            'ExploreTopPost'=>ExplorePagePost::getPostType('ExploreTopPost'),
            'HomePostContainer'=>ExplorePagePost::getPostType('HomePostContainer'),
            'ExploreSidebar'=>ExplorePagePost::getPostType('ExploreSidebar'),
            'ExploreBottomPost'=>ExplorePagePost::getPostType('ExploreBottomPost'),
        ]]); 
    }
}
