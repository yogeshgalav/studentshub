<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){
    Route::get('/my-institute', 'InstituteController@Institute');
    Route::get('/students', 'InstituteController@indexStudents');
    Route::get('/students/{user}', 'InstituteController@showStudents');
    
    //post routes
});