<?php

namespace App\Http\Controllers;

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
}
