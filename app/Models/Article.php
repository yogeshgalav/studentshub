<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Storage;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use App\Services\simple_html_dom;

class Article extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use Loggable;

    public function createFromContent($data){
        $simple_html_dom = new simple_html_dom;
        $dom = $simple_html_dom->extactImageFiles($data['article_html_content'], "post-image");
        $post_content_id= self::insertGetId(['html_content'=>$data['article_html_content']]);
        foreach($dom->files as $file){
            $newFile= new SthubFile();
            $newFile->fileable_id=$post_content_id;
            $newFile->fileable_type='App\Models\Article';
            $newFile->file_ext=Storage::disk('local')->getMimeType($file['file_path']);
            $newFile->file_size=Storage::disk('local')->size($file['file_path']);
            $newFile->file_name=$file['file_name'];
            $newFile->user_id=Auth::user()->id;
            $newFile->save();
        }

        return $post_content_id;
    }
}
