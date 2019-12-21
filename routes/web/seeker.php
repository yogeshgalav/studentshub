<?php

Route::group(['middleware'=>['auth']],function(){
    Route::get('/check-in', 'PagesController@checkin');
    //post routes
});