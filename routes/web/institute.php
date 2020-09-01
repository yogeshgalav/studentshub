<?php

Route::group(['middleware'=>['auth']],function(){
    Route::get('/institute', 'PagesController@Institute');
    
    //post routes
});