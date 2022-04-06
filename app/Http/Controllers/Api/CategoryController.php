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
    
    public function show(Category $category)
    {
        $category_data = Category::where('id', $category->id)->with(['courses','subjects'])->first();
        return response()->json(['success'=>[
            'category'=>$category_data,
        ]]);
      }
}
