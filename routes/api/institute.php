<?php

Route::group(['middleware'=>['auth:api']],function(){
    Route::get('/getInstitutes', 'InstituteController@index')->middleware('admin');
    Route::post('/save-institute', 'InstituteController@create')->middleware('admin');
    Route::get('/institute/{instituteId}/get-institute-details', 'InstituteController@show');
    Route::post('/institute/{instituteId}/update-user', 'InstituteUserController@updateInstituteUser');
    
    //post routes
});