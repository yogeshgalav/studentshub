<?php

use Illuminate\Support\Facades\Route;


    Route::get('/dashboard','PagesController@dashboard');
    Route::get('/checkin', 'PagesController@checkin');
    //post routes
    Route::get('/create-post','PagesController@createPost');
    Route::get('/edit-post','PagesController@editPost');
        
    Route::get('/profile', 'PagesController@profile');
    
    Route::get('/classrooms', 'PagesController@classroomList');
    
    Route::get('/classroom/{classroom_id}','PagesController@classroom');