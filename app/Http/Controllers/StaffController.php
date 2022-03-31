<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Career;
use DB;

class StaffController extends Controller
{
   //
   public function leadIndexPage(){        
        return inertia('staff/lead-index');
    }
   public function leadShowPage(){        
        return inertia('staff/lead-show', ['lead' => 'xyz']);
    }
   public function manageCoursePage(){        
        return inertia('staff/manage-course');
    }
   public function manageJobsPage(){
     // $careers= Career::all(); 
      $careers=\DB::table('careers as ca')
         ->leftJoin('categories as cat','cat.id','=','ca.category_id')
        ->select(['ca.name as career_name','ca.id as career_id','cat.name as category_name','cat.id as category_id'])->get();
     /* SELECT careers.name as carrers_name, categories.id as categories_id, categories.name as categories_name
FROM careers
LEFT JOIN categories
ON careers.category_id=categories.id
ORDER BY careers.name;  */   
    $categories = \App\Models\Category::get();  
    return inertia('staff/manage-job',[
        'careers'=>$careers,
    'categories' => $categories
    ] );
    }
   public function userFeedbacksPage(){        
        return inertia('staff/user-feedbacks');
    }
   public function userReportsPage(){        
        return inertia('staff/user-reports');
    }
}
