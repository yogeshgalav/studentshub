<?php

Route::group(['middleware'=>['auth']],function(){
    Route::get('/education-details', 'PagesController@checkin');
    //post routes
});