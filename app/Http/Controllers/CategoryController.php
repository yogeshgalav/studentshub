<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class CategoryController extends Controller
{
    //get all categories for creating post autocomplete
    public function index(Request $request)
    {
        $categories=Subject::where('Subject_name','LIKE','%'.$request->subject.'%')->getAllCategories();
        return response()->json([
            'success'=>[
                'categories'=>$categories
            ]
        ]);
    }
}
