<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //get all categories for creating post autocomplete
    public function index(Request $request)
    {
        $categories=Category::all();
        return response()->json([
            'success'=>[
                'categories'=>$categories,
            ]
        ]);
    }
    
    public function show(Request $request){
        $category=\App\Models\Category::where('category_url', $request->route('id'))->with('courses')->with('subjects')->firstOrFail();
        $post=new \App\Post;
        $posts = $post->getCategoryPosts($category->id);

        return response()->json(['success'=>[
            'posts'=>\Sthub::convert_from_latin1_to_utf8_recursively($posts),
            'category'=>$category,
        ]]);
      }
}
