
<?php

Route::group(['middleware'=>['auth:api']],function(){
    Route::get('/get-student-posts','PostController@getStudentPosts');
    Route::get('/get-subjects/{category_id}','SubjectController@index');
    Route::get('/get-subject-list/{category_id}','SubjectController@subjectList');
    Route::post('/submit-post','PostController@create');
    Route::post('/save-post-image','PostController@createImage');
    Route::post('/add-doubt','DoubtController@addDoubt');
    Route::get('/get-doubts','DoubtController@getDoubts');
    Route::post('/doubt/{doubtId}/add-answer','DoubtAnswersController@addDoubtAnswer');
    Route::get('/doubt/{doubtId}/get-answers','DoubtAnswersController@getDoubtAnswers');
    
    
});