<?php

use Illuminate\Support\Facades\Route;


    Route::get('/dashboard','PagesController@dashboard');
    Route::get('/checkin', 'PagesController@checkin');
    Route::get('/post/{post_id}','PagesController@getPost');
    
    Route::get('/explore', 'PagesController@explore');
    
    Route::get('/profile', 'PagesController@profile');
    
    Route::get('/classrooms', 'PagesController@classroomList');
    
    Route::get('/classroom/{classroom_id}','PagesController@classroom');