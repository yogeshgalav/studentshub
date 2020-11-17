<?php

Route::group(['middleware'=>['auth']],function(){
    Route::get('/my-institute', 'PagesController@Institute');
    
    //post routes
});