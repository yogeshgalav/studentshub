<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){
    // Route::get('/check-in', 'SeekerController@checkin');
    // Route::get('/seeker', 'SeekerController@seekerCheckin');
    // Route::get('/education-details', 'SeekerController@educationDetail');
    Route::get('/account-settings', 'SeekerController@accountSetting');
    Route::get('/profile/{profileId}', 'SeekerController@profile');
    Route::get('/earn-money', 'SeekerController@earnMoney');
    Route::get('/notifications', 'SeekerController@notifications');
    Route::get('/category', 'SeekerController@category');
    //doubts
    Route::get('/doubts','SeekerController@doubtPage');
    Route::get('/doubt/{doubt}','SeekerController@doubtAnswersPage');
    //post routes
});
