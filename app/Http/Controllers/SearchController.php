<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Search;
use App\Models\Subject;

class SearchController extends Controller
{
    public function searchPosts(Request $request){
      $post=new \App\Post;
      $response = $post->getSearchPosts($request);
      
      $search=new \App\Models\Search;
      $search->query=trim($request->search);
      if($response){
        $search->success=true;
      }else{
        $search->success=false;
      }
      $search->save();

      return $response;
    }

    public function searchSubjectPosts(Request $request){
      $post=new \App\Post;
      $response = $post->getSearchPosts($request);
      
      $search=new \App\Models\Search;
      $search->query=trim($request->search);
      if($resonse){
        $search->success=true;
      }else{
        $search->success=false;
      }
      $search->save();

      return $response;
    }
}
