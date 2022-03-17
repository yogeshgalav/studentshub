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
        return inertia('staff/lead-show');
    }
   public function manageCoursePage(){        
        return inertia('staff/manage-course');
    }
   public function manageJobsPage(){        
        return inertia('staff/manage-job');
    }
   public function userFeedbacksPage(){        
        return inertia('staff/user-feedbacks');
    }
   public function userReportsPage(){        
        return inertia('staff/user-reports');
    }
}
