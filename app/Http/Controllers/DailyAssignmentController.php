<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherDailyAssignment\StoreRequest;
use App\Models\DailyQuestion;

class DailyAssignmentController extends Controller
{
    //
    public function addDailyAssignment(StoreRequest $request)
    {
        if($request->has('question')) {
            $dailyQuestion = DailyQuestion::firstOrNew([
                'attempt_date' => $request->attempt_date,
                'unit_id' => $request->unit_id
            ]);

            $dailyQuestion->save();

            return response()->json(['success'=>[
                'assignment'=>$dailyQuestion
            ]]);
        }

    }

}
