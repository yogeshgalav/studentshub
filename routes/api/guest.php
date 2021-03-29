<?php

use Illuminate\Support\Facades\Route;



Route::post('/subscribe','GuestController@update');
Route::get('/get-post-content/{post_id}','PostController@show');
Route::post('/login','AuthController@loginViaApi');
Route::post('/register','AuthController@registerViaApi');
Route::post('/member-request','GuestController@memberRequest');

Route::post('/forgot-password','AuthController@processForgotPassword');
Route::post('/reset-password','AuthController@resetPassword2')->middleware('auth:api');
Route::post('/reset-password/{token}','AuthController@resetPassword');
Route::post('/feedback','GuestController@feedback');
Route::post('/contactus','GuestController@contactus');
Route::post('/faq','GuestController@faq');
// Route::get('/get-view-post/{ViewPostId}', 'PostController@viewPost');
Route::get('/get-explore-posts', 'ExploreController@index');

Route::get('/get-search-posts', 'PostController@searchPosts');
Route::get('/get-course-posts/{courseId}', 'PostController@coursePosts');
Route::get('/get-subject-posts/{subjectId}', 'PostController@subjectPosts');
Route::get('/get-category-details/{id}', 'PostController@categoryDetails');
