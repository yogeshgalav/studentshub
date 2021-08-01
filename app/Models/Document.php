<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Storage;

class Document extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];

    public function createNewDocument($data,$access){
        $document=self::create([
            'link'=>$data['document_link'],
            'access'=>$access,
            'ext'=>'pdf',
        ]);
        return $document->id;
    }
    // foreach($files as $file){
    //     $file_name=uniqid();
    //     $file_path="documents/".$file_name;
    //     Storage::disk('local')->put($file_path, $file);

    //     $newFile= new SthubFile();
    //         $newFile->fileable_id=$document->id;
    //         $newFile->fileable_type='App\Models\Document';
    //         $newFile->file_ext=Storage::disk('local')->getMimeType($file_path);
    //         $newFile->file_size=Storage::disk('local')->size($file_path);
    //         $newFile->file_name=$file_name;
    //         $newFile->user_id=Auth::user()->id;
    //         $newFile->save();
    //     }
    // }
}
