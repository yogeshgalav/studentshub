
<?php

Route::group(['middleware'=>['auth:api']],function(){
    Route::get('/get-posts','PostController@getPosts');
    Route::post('/post-like','LikeController@post');
    Route::post('/post-save','PostController@savePost');
    Route::post('/post-report','PostController@reportPost');
    Route::get('/get-categories','CategoryController@index');
    Route::post('/checkin','StudentController@create');
    Route::post('/search-course','StudentController@courseList');
    Route::post('/search-institute','StudentController@instituteList');
});