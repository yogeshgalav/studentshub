<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Storage;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class Article extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use Loggable;

    public function createFromContent($data){
        // $path =  (dirname(__FILE__) .'/../Services/simple_html_dom.php');
        //     require($path);
        // // Create DOM from URL or file
        // $html = str_get_html($data['htmlContent']);
        // $files=[];
        // foreach($html->find('img') as $element){
        //     $base64_image=$element->src;
        //     if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
        //         $data = substr($base64_image, strpos($base64_image, ',') + 1);
        //         $pos  = strpos($base64_image, ';');
        //         $file_type = explode(':image/', substr($base64_image, 0, $pos))[1];
                
        //         $file_name=uniqid().'.'.$file_type;
        //         $file_path="post-images/".$file_name;
        //         Storage::disk('local')->put($file_path, base64_decode($data));
        //         $files[]=['file_name'=>$file_name,'file_type'=>$file_type,'file_path'=>$file_path];
        //         $element->src="/".$file_path;
        //     }
        // }
        
        $post_content_id= self::insertGetId(['html_content'=>$data['article_html_content']]);
        // foreach($files as $file){
        //     $newFile= new SthubFile();
        //         $newFile->fileable_id=$post_content_id;
        //         $newFile->fileable_type='App\Models\Article';
        //         $newFile->file_ext=Storage::disk('local')->getMimeType($file['file_path']);
        //         $newFile->file_size=Storage::disk('local')->size($file['file_path']);
        //         $newFile->file_name=$file['file_name'];
        //         $newFile->user_id=Auth::user()->id;
        //         $newFile->save();
        // }

        return $post_content_id;
    }
}
