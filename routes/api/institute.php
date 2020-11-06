<?php

Route::group(['middleware'=>['auth:api']],function(){
    Route::get('/institute/{instituteId}/get-institute-details', 'InstituteUserController@showInstituteUsers');
    Route::post('/institute/{instituteId}/update-user', 'InstituteUserController@updateInstituteUser');
    
    //post routes
});