<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Career;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function createOrUpdate (Request $request)
    {   
        
        if($request->career_id){
            $career = Career::find($request->career_id);
        }
        else{
            $career = new Career();
        }
            
            $career->name = $request->career_name;
            $career->category_id = $request->category_id;
            $career->save();

            return response()->json([
                'success'=>[
                    'career'=>$career,
                ]
            ]);
    }

    public function delete ($career_id)
    {
        $career = Career::find($career_id);
        $career->delete();
        return 'success';
    }
}