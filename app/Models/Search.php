<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Search extends Model
{
    //
    public function add(Request $request)
    {
        return $this;
    }
    public function subjectResult($subject_name){
        $subject=Subject::where('Subject_name',$subject_name)->first();
        $subjects=Subject::where('parent_subject_id',$subject->id)->get();
        
        $posts= SthubPost::whereHas('post',function($query)use($subject){
            $query->where('subject_id',$subject->id);
        })->get();
        
        return ['posts'=>$posts,'subjects'=>$subjects];
    }
    public function queryResult($query){
        $query_params=explode(' ',$query);
        $posts=SthubPost::whereHas('post',function($query)use($query_params){
            $query->where('post_heading','LIKE',implode('%',$query_params).'%');
        })->get();
        
        if(is_null($posts)){
            foreach($query_params as $param){
                $subject=Subject::where('Subject_name',$param)->first();
                if($subject){break;}
            }
            $posts=$subject->posts->sthubPost;
        }
        return $posts;
    }
}
