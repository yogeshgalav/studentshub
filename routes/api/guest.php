<?php



Route::post('/subscribe','GuestController@update');
Route::get('/get-post-content/{post_id}','PostController@show');
Route::post('/login','AuthController@login');
Route::post('/register','AuthController@register');

Route::post('/forgot-password','AuthController@processForgotPassword');
Route::post('/reset-password','AuthController@resetPassword');
// Route::get('/get-view-post/{ViewPostId}', 'PostController@viewPost');
Route::get('/get-explore-posts', 'ExploreController@index');

Route::get('/search', 'PostController@searchPosts');
Route::get('/course/{courseUrl}', 'PostController@coursePosts');
Route::get('/subject/{subjectUrl}', 'PostController@subjectPosts');
Route::get('/category/{categoryUrl}', 'PostController@categoryPosts');
