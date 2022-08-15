<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/membership-plan','GuestController@membershipPlan');
Route::get('/get-started','AuthController@getStartedPage');
Route::get('/find-interest-field','GuestController@FindInterestField');
Route::get('/forgot-password','GuestController@forgotPasswordPage');
Route::get('/reset-password/{token}','GuestController@resetPassword');
Route::get('/reset-password','GuestController@resetPassword');
Route::get('/feedback','GuestController@feedbackPage');
Route::get('/contactus','GuestController@contactusPage');
Route::get('/faq','GuestController@faqPage');
Route::get('/logout','AuthController@logout');

Route::post('/login', [AuthController::class, 'loginViaOtp']);
Route::post('/register', [AuthController::class, 'registerViaOtp']);

Route::get('/post/{ViewPostId}', 'GuestController@viewPost');
Route::get('/social-auth/{provider}', 'AuthController@redirectToProvider');
Route::get('/callback/{provider}', 'AuthController@handleProviderCallback');
//explore routes
Route::get('/search', 'GuestController@searchPage');
Route::get('/course/{courseUrl}', 'GuestController@coursePage');
Route::get('/subject/{subjectUrl}', 'GuestController@subjectPage');
Route::get('/category/{categoryUrl}', 'GuestController@categoryPage');
