<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExplorePagePost extends Model
{
    //
    
    public function getPosts(){
        $posts=ViewPost::getExplorePagePosts();
    }
}
