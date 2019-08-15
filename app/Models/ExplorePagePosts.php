<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExplorePagePosts extends Model
{
    //
    
    public function getPosts(){
        $posts=ViewPost::getExplorePagePosts();
    }
}
