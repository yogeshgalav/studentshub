
<?php

Route::group(['middleware'=>['auth:api']],function(){
    Route::get('/get-posts','PostController@getPosts');
    Route::post('/post/{postId}/post-like','LikeController@index');
    Route::get('/get-categories','CategoryController@index');
    Route::post('/checkin','StudentController@create');
    Route::post('/search-course','StudentController@courseList');
    Route::post('/search-institute','StudentController@instituteList');
});