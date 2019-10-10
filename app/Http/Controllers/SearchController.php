<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Search;
use App\Models\Subject;

class SearchController extends Controller
{
    //
    public function create($subject,Request $request)
    {
      $search=new Search();
      $result=$search->add($request)->subjectResult($subject);

      return view('guest.explore')
        ->with('categories',$result['subjects'])
        ->with('posts',$result['posts']);

    }

    public function create2(Request $request)
    {
      $search=new Search();
      $posts=$search->add($request)->queryResult($request->search);
        
      return view('guest.explore')
        ->with('categories',Subject::getAllCategories())
        ->with('posts',$posts);

    }
}
