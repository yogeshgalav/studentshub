<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:api']],function(){
    Route::get('/getInstitutes', 'InstituteController@adminIndex')->middleware('admin');
    Route::post('/save-institute', 'InstituteController@create')->middleware('admin');
    Route::get('/institute/{instituteId}/get-institute-details', 'InstituteController@show');
    Route::get('/students', 'InstituteController@indexStudents');
    Route::get('/student/{user}', 'InstituteController@showStudent');
    Route::post('/student/{user}', 'InstituteController@updateStudent');
    Route::post('/institute/{instituteId}/update-user', 'InstituteUserController@updateInstituteUser');
    Route::post('/add-details','InstituteController@addAdminiDetails');
    Route::delete('/instituteuser/{instituteuser}','InstituteController@delete');
    Route::post('/add-contact','InstituteController@addOrUpdate');
    Route::delete('/contact/{contact}','InstituteController@deleteContact');
    Route::post('/save-institute-profile', 'InstituteController@saveInstiProfile');
    Route::post('/upload-banner', 'InstituteController@savebanner');
    Route::post('/update-institute-blog/{institute}','InstituteController@updateInstituteBlog');
    //post routes
});