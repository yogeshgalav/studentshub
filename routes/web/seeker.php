<?php

Route::group(['middleware'=>['auth']],function(){
    Route::get('/education-details', 'PagesController@checkin');
    Route::get('/profile/{profileId}', 'PagesController@profile');
    //post routes
});