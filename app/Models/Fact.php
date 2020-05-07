<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fact extends Model
{
    //
    public function createNewFact($data){
        
        $file=File::get($data['image']);
        $file_name=uniqid().'.'.$file->getClientOriginalExtension();
        $file_path="post-images/".$file_name;
        storage()->put($file_path);
        
        $post_content_id=self::insertGetId([
            'image'=>$file_path,
            'description'=>$data['description'],
        ]);

        $newFile= new SthubFile();
        $newFile->fileable_id=$post_content_id;
        $newFile->fileable_type='App\Models\Fact';
        $newFile->file_ext=storage()->getMimeType($file_path);
        $newFile->file_size=storage()->size($file_path);
        $newFile->file_name=$file_name;
        $newFile->user_id=Auth::user()->id;
        $newFile->save();
        return $post_content_id;
    }
}
