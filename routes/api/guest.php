<?php

use Illuminate\Support\Facades\Route;



Route::post('/subscribe','GuestController@update');
Route::get('/get-post-content/{post}','PostController@show');
Route::post('/verify-contact',[App\Http\Controllers\Api\AuthController::class,'verifyContact']);
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
Route::get('/search-posts', [App\Http\Controllers\Api\PostController::class, 'searchPosts']);
Route::get('/search-course', [App\Http\Controllers\Api\CourseController::class, 'index']);
Route::get('/search-subject', [App\Http\Controllers\Api\SubjectController::class, 'index']);
Route::get('/search-institute', [App\Http\Controllers\Api\InstituteController::class, 'index']);

Route::get('/institute/{id?}',  [App\Http\Controllers\Api\InstituteController::class, 'show']);
Route::get('/course/{id?}',  [App\Http\Controllers\Api\CourseController::class, 'show']);
Route::get('/subject/{subject}',  [App\Http\Controllers\Api\SubjectController::class, 'show']);
Route::get('/category/{category}',  [App\Http\Controllers\Api\CategoryController::class, 'show']);
Route::get('/get-categories', 'CategoryController@index');
Route::post('/add-course','CourseController@createOrUpdate');
Route::delete('/course/{course}','CourseController@delete');
Route::get('/{commentable_type}/{commentable_id}/comment', 'CommentController@get');
