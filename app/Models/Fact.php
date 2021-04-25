<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fact extends Model
{
    //
    public function createNewFact($data){
        $image = $data['fact_image']; // image base64 encoded
        preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
        $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
        $image = str_replace(' ', '+', $image);
        $file_name = 'image_' . time() . '.' . $image_extension[1]; //generating unique file name;
        $file_path="/public/post-images/".$file_name;
        $get_file_path="/storage/post-images/".$file_name;
        \Storage::put($file_path,base64_decode($image));

        $post_content_id=self::insertGetId([
            'image_path'=>$get_file_path,
        ]);

        $newFile= new SthubFile();
        $newFile->fileable_id=$post_content_id;
        $newFile->fileable_type='App\Models\Fact';
        $newFile->file_ext=\Storage::getMimeType($file_path);
        $newFile->file_size=\Storage::size($file_path);
        $newFile->file_name=$file_name;
        $newFile->user_id=\Auth::user()->id;
        $newFile->save();
        return [$post_content_id,$get_file_path];
    }
}
