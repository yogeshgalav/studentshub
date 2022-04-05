
<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:api']],function(){
    Route::post('/submit-post','PostController@create');
    Route::post('post/{post}/update','PostController@update');
    Route::get('/get-student-posts','PostController@getStudentPosts');
    Route::post('/save-post-image','PostController@createImage');
    Route::post('/add-doubt','DoubtController@create');
    Route::post('/doubt/{doubt}/edit','DoubtController@update');
    Route::delete('/doubt/{doubt}','DoubtController@delete');
    Route::get('/get-student-course-details','StudentController@getCourseSubjects');
    //doubt
    Route::post('/doubt/{doubt}/add-answer','DoubtAnswersController@addDoubtAnswer');
    Route::get('/doubt/{doubt}/get-answers','DoubtAnswersController@getDoubtAnswers');
});
