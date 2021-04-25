<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){
    Route::get('/my-institute', 'InstituteController@Institute');
    
    //post routes
});