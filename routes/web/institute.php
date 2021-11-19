<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){
    Route::get('/my-institute', 'InstituteController@Institute');
    Route::get('/students', 'InstituteController@indexStudents');
    Route::get('/student/{user}', 'InstituteController@showStudent');
    
    //post routes
});