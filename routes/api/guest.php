<?php

use Illuminate\Support\Facades\Route;



Route::post('/subscribe','GuestController@update');
Route::get('/get-post-content/{post}','PostController@show');
Route::post('/login',[App\Http\Controllers\AuthController::class,'loginViaApi']);
Route::post('/register',[App\Http\Controllers\AuthController::class,'registerViaApi']);
Route::post('/member-request','GuestController@memberRequest');

Route::post('/forgot-password',[App\Http\Controllers\AuthController::class,'processForgotPassword']);
Route::post('/reset-password',[App\Http\Controllers\AuthController::class,'resetPassword2'])->middleware('auth:api');
Route::post('/reset-password/{token}',[App\Http\Controllers\AuthController::class,'resetPassword']);
Route::post('/feedback',[App\Http\Controllers\Api\GuestController::class, 'feedback']);
Route::post('/contactus', [App\Http\Controllers\Api\GuestController::class, 'contactus']);
Route::post('/faq',[App\Http\Controllers\Api\GuestController::class, 'faq']);
// Route::get('/get-view-post/{ViewPostId}', 'PostController@viewPost');
Route::get('/get-explore-posts', 'ExploreController@index');

//search page routes
Route::get('/search-posts', [App\Http\Controllers\Api\SearchController::class, 'searchPosts']);
Route::get('/search-course', [App\Http\Controllers\Api\SearchController::class, 'courseList']);
Route::get('/search-subject', [App\Http\Controllers\Api\SearchController::class, 'subjectList']);
Route::get('/search-institute', [App\Http\Controllers\Api\SearchController::class, 'instituteList']);

Route::get('/get-course-details/{id?}', 'PostController@courseDetails');
Route::get('/get-subject-details/{id}', 'PostController@subjectDetails');
Route::get('/get-category-details/{id}', 'PostController@categoryDetails');
Route::get('/get-categories', 'CategoryController@index');
