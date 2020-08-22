
<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:api']],function(){
    Route::get('/get-posts','PostController@getPosts');
    Route::post('/post-like','LikeController@post');
    Route::post('/post-save','PostController@savePost');
    Route::post('/post-report','PostController@reportPost');
    Route::post('/save-profile','UserController@saveProfile');
    Route::get('/get-categories','CategoryController@index');
    Route::post('/checkin','StudentController@create');
    Route::post('/search-course','StudentController@courseList');
    Route::post('/search-subject','StudentController@subjectList');
    Route::post('/search-institute','StudentController@instituteList');
});
