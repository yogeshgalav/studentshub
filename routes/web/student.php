<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){
    //post routes
    Route::get('/share-your-knowledge','StudentController@sharePost');
    Route::get('/my-course', 'StudentController@myCoursePage');
    Route::get('/post/{post}/edit','StudentController@editPost');
    Route::get('/classroom/{classroomId}/daily-attempt','StudentController@dailyAssignmentAttemptPage');
    Route::get('/chatroom', 'StudentController@ChatroomindexPage');
    Route::post('/save-daily-answers','StudentController@saveDailyAnswer');
    Route::get('/more-apps', 'StudentController@moreApps');
    Route::get('/ask-doubt','StudentController@askDoubt');
    Route::get('/edit-doubt/{doubt_id}','StudentController@editDoubtPage');
});