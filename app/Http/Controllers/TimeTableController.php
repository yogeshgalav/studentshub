<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeTableController extends Controller
{
    //
    public function save(Request $request)
    {
        \Session::put('working_days', $request->working_days);
        \Session::put('subject_per_day', $request->subject_per_day);
        \Session::put('total_subjects', $request->total_subjects);

        return redirect('/subjects');
    }

    public function subjects()
    {
        return view('subjects')
        ->with('total_subjects', session('total_subjects'))
        ->with('working_days', session('working_days'))
        ->with('subject_per_day', session('subject_per_day'))
        ->with('total_hours', session('working_days')*session('subject_per_day'));
    }
}
