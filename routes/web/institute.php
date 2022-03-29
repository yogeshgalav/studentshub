<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){
    Route::get('/institute/admin', 'InstituteController@Institute');
    Route::get('/my-institute', 'InstituteController@myInstitute');
    Route::get('/students', 'InstituteController@indexStudents');
    Route::get('/student/{user}', 'InstituteController@showStudent');
    
    //post routes
});