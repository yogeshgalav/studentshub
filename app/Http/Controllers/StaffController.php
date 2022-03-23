<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    $categories = \App\Models\Category::get();  
    return inertia('staff/manage-course',[
    'categories' => $categories
    ] );
    }
   public function manageJobsPage(){      
    $categories = \App\Models\Category::get();  
        return inertia('staff/manage-job', ['categories' => $categories] ,['job' => 'xyz']);
    }
    public function addJobsPage(){        
        return inertia('staff/add-job');
    }
   public function userFeedbacksPage(){        
        return inertia('staff/user-feedbacks');
    }
   public function userReportsPage(){        
        return inertia('staff/user-reports');
    }
}
