<?php

Route::get('/login','PagesController@loginPage');
Route::get('/get-started','PagesController@registerPage');
Route::get('/forgot-password','PagesController@forgotPassword')->name('forgot-password');
Route::get('/reset-password/{token}','PagesController@resetPassword');
Route::get('/logout','AuthController@logout');

Route::get('/post/{ViewPostId}', 'PagesController@viewPost');
Route::get('/explore/{subjectName}', 'SearchController@create');
Route::get('/explore', 'SearchController@create2');
Route::post('/register','AuthController@register');
Route::post('sociallogin/{provider}', 'AuthController@SocialSignup');
Route::get('auth/{provider}/callback', 'OutController@index')->where('provider', '.*');