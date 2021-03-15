<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){
    Route::get('/check-in', 'PagesController@checkin');
    Route::get('/education-details', 'PagesController@educationDetail');
    Route::get('/seeker', 'PagesController@seeker');
    Route::get('/profile/{profileId}', 'PagesController@profile');
    //post routes
});