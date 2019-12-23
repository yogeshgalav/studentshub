
<?php

Route::group(['middleware'=>['auth:api']],function(){

    Route::get('/get-categories','CategoryController@index');
    Route::get('/get-subjects/{category_id}','SubjectController@index');
    Route::get('/get-subject-list/{category_id}','SubjectController@subjectList');
    Route::post('/submit-post','PostController@create');
    Route::post('/save-post-image','PostController@createImage');
    Route::post('/add-question','QuestionController@addQuestion');
    Route::get('/get-question','QuestionController@getQuestion');
    
});