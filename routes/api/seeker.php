
<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/get-posts', [App\Http\Controllers\PostController::class, 'getPosts']);
    Route::post('/post-like', 'LikeController@post');
    Route::post('/post-save', 'PostController@savePost');
    Route::post('/post-report', 'PostController@reportPost');
        //profile
    Route::get('/get-profile','UserController@getProfile');
    Route::post('/save-profile', 'UserController@saveProfile');
    Route::get('/get-categories', 'CategoryController@index');
    Route::post('/checkin/student', 'StudentController@create');
    Route::post('/checkin/teacher', 'InstituteUserController@teacherCheckin');
    Route::post('/search-course', 'StudentController@courseList');
    Route::post('/search-subject', 'StudentController@subjectList');
    Route::post('/search-institute', 'StudentController@instituteList');
});
