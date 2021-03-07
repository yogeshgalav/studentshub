<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){
    //post routes
    Route::get('/share-your-knowledge','PagesController@sharePost');
    Route::get('/create-post','PagesController@createPost');
    Route::get('/edit-post','PagesController@editPost');
    Route::get('/classroom/{classroomId}/daily-attempt','StudentController@dailyAssignmentAttemptPage');
    Route::post('/save-daily-answers','StudentController@saveDailyAnswer');
});