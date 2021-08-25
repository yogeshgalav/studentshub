
<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/get-posts', [App\Http\Controllers\Api\PostController::class, 'getPosts']);
    Route::post('/user-like/{type}', 'LikeController@updateOrDelete');
    Route::post('/post-save', 'PostController@savePost');
    Route::post('/post-report', 'PostController@reportPost');
        //profile
    Route::get('/get-profile','UserController@getProfile');
    Route::post('/save-profile', 'UserController@saveProfile');
    Route::get('/get-categories', 'CategoryController@index');
    Route::post('/checkin/student', [App\Http\Controllers\Api\StudentController::class, 'create']);
    Route::post('/checkin/teacher', 'InstituteUserController@teacherCheckin');
    Route::get('/search-user', [App\Http\Controllers\Api\SearchController::class, 'searchUser']);

    // Notifications
    Route::get('/notifications', 'NotificationController@index');

    // Push Subscriptions
    Route::post('/subscriptions', 'PushSubscriptionController@update');
    Route::post('/subscriptions/delete', 'PushSubscriptionController@destroy');

    //comments
    Route::get('/{commentable_type}/{commentable_id}/comment', 'CommentController@get');
    Route::post('/comment', 'CommentController@create');

});
