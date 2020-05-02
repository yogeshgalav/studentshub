<?php



Route::post('/subscribe','GuestController@update');
Route::get('/get-post-content/{post_id}','PostViewController@index');
Route::post('/login','AuthController@login');
Route::post('/register','AuthController@register');

Route::post('/forgot-password','AuthController@processForgotPassword');
Route::post('/reset-password','AuthController@resetPassword');
// Route::get('/get-view-post/{ViewPostId}', 'PostController@viewPost');
Route::get('/get-explore-posts', 'ExploreController@index');

Route::get('/explore', 'SearchController@searchPosts');
Route::get('/explore/{subject}', 'SearchController@searchSubjectPosts');
