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
Route::post('/feedback',[App\Http\Controllers\Api\GuestController::class, 'feedback']);
Route::post('/contactus', [App\Http\Controllers\Api\GuestController::class, 'contactus']);
Route::post('/faq',[App\Http\Controllers\Api\GuestController::class, 'faq']);
// Route::get('/get-view-post/{ViewPostId}', 'PostController@viewPost');
Route::get('/get-explore-posts', 'ExploreController@index');

Route::get('/get-search-posts', 'PostController@searchPosts');
Route::get('/get-course-posts/{courseId}', 'PostController@coursePosts');
Route::get('/get-subject-posts/{subjectId}', 'PostController@subjectPosts');
Route::get('/get-category-posts/{categoryId}', 'PostController@categoryPosts');
