
<?php

Route::get('/get-posts','HomeController@index');
Route::post('/post/{postId}/post-like','LikeController@index');
Route::get('/get-categories','CategoryController@index');
