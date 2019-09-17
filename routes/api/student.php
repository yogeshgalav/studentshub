
<?php

Route::group(['middleware'=>['auth:api',]],function(){

    Route::post('/submit-post','HomeController@create');
    Route::get('/get-posts','HomeController@index');
    Route::get('/get-categories','CategoryController@index');
    Route::get('/get-subjects/{category_id}','SubjectController@index');
    Route::get('/get-subject-list/{category_id}','SubjectController@subjectList');
    
});