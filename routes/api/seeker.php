
<?php

Route::get('/get-posts','PostController@getSeekerPosts');
Route::post('/post/{postId}/post-like','LikeController@index');
Route::get('/get-categories','CategoryController@index');
Route::post('/checkin','StudentController@create');
