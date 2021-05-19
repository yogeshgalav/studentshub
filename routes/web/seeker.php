<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){
    Route::get('/check-in', 'SeekerController@checkin');
    Route::get('/seeker', 'SeekerController@seekerCheckin');
    Route::get('/education-details', 'SeekerController@educationDetail');
    Route::get('/account-settings', 'SeekerController@accountSetting');
    Route::get('/profile/{profileId}', 'SeekerController@profile');
    Route::get('/search', 'SeekerController@searchPage');

    //post routes
});
