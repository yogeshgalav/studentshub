<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){
    //post routes
    Route::get('/share-your-knowledge','StudentController@sharePost');
    Route::get('/my-course', 'StudentController@myCoursePage');
    Route::get('/edit-post','StudentController@editPost');
    Route::get('/classroom/{classroomId}/daily-attempt','StudentController@dailyAssignmentAttemptPage');
    Route::post('/save-daily-answers','StudentController@saveDailyAnswer');
});