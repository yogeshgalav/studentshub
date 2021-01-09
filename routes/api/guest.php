<?php

use Illuminate\Support\Facades\Route;



Route::post('/subscribe','GuestController@update');
Route::get('/get-post-content/{post_id}','PostController@show');
Route::post('/login','AuthController@loginViaApi');
Route::post('/register','AuthController@registerViaApi');
Route::post('/member-request','GuestController@memberRequest');

Route::post('/forgot-password','AuthController@processForgotPassword');
Route::post('/reset-password/{token}','AuthController@resetPassword');
Route::post('/reset-password','AuthController@resetPassword2')->middleware('auth:api');
// Route::get('/get-view-post/{ViewPostId}', 'PostController@viewPost');
Route::get('/get-explore-posts', 'ExploreController@index');

Route::get('/search', 'PostController@searchPosts');
Route::get('/course/{courseUrl}', 'PostController@coursePosts');
Route::get('/subject/{subjectUrl}', 'PostController@subjectPosts');
Route::get('/category/{categoryUrl}', 'PostController@categoryPosts');
