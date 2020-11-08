<?php

Route::group(['middleware'=>['auth']],function(){
    Route::get('/my-institute', 'PagesController@Institute');
    Route::get('/institute/{id}', 'PagesController@Institute');
    
    //post routes
});