<?php

Route::get('/login','PagesController@loginPage');
Route::get('/get-started','PagesController@registerPage');
Route::get('/forgot-password','PagesController@forgotPasswordPage');
Route::get('/reset-password/{token}','UserController@resetPassword');
Route::get('/reset-password','UserController@resetPassword');
Route::get('/logout','AuthController@logout');

Route::post('/login','AuthController@login');
Route::post('/register','AuthController@register');

Route::get('/post/{ViewPostId}', 'PagesController@viewPost');
Route::get('/social-auth/{provider}', 'AuthController@redirectToProvider');
Route::get('/callback/{provider}', 'AuthController@handleProviderCallback');
//explore routes
Route::get('/search', 'PagesController@searchPage');
Route::get('/course/{courseUrl}', 'PagesController@coursePage');
Route::get('/subject/{subjectUrl}', 'PagesController@subjectPage');
Route::get('/category/{categoryUrl}', 'PagesController@categoryPage');
