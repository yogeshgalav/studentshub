<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function getInterests(){
        $categories=\App\Models\Category::get();
        foreach($categories as $category){
            $category->percent=rand(1,99);
        }
        return response()->json(['success'=>[
            'interests'=>$categories
        ]]);
    }
}
