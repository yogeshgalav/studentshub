
<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:api']],function(){
    Route::post('/submit-post','PostController@create');
    Route::get('/get-student-posts','PostController@getStudentPosts');
    Route::post('/save-post-image','PostController@createImage');
    Route::post('/add-doubt','DoubtController@addDoubt');
    Route::get('/get-doubts','DoubtController@getDoubts');
    Route::post('/search-doubts','DoubtController@searchDoubts');
    Route::get('/get-student-course-details','StudentController@getCourseSubjects');
    //doubt
    Route::post('/doubt/{doubtId}/add-answer','DoubtAnswersController@addDoubtAnswer');
    Route::get('/doubt/{doubtId}/get-answers','DoubtAnswersController@getDoubtAnswers');
});
