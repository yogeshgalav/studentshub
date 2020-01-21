<?php

Route::get('/login','PagesController@loginPage');
Route::get('/get-started','PagesController@registerPage');
Route::get('/forgot-password','PagesController@forgotPasswordPage');
Route::get('/reset-password/{token}','PagesController@resetPassword');
Route::get('/logout','AuthController@logout');

Route::get('/post/{ViewPostId}', 'PagesController@viewPost');
Route::get('/explore/{subject}', 'SearchController@create');
Route::get('/explore', 'SearchController@create2');
Route::post('/register','AuthController@register');
Route::get('/social-auth/{provider}', 'AuthController@redirectToProvider');
Route::get('/callback/{provider}', 'AuthController@handleProviderCallback');