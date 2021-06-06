
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
    Route::post('/search-course', [App\Http\Controllers\Api\SearchController::class, 'courseList']);
    Route::post('/search-subject', [App\Http\Controllers\Api\SearchController::class, 'subjectList']);
    Route::post('/search-institute', [App\Http\Controllers\Api\SearchController::class, 'instituteList']);

    // Notifications
    Route::get('/notifications', 'NotificationController@index');
    Route::patch('/notifications/{id}/read', 'NotificationController@markAsRead');
    Route::post('/notifications/mark-all-read', 'NotificationController@markAllRead');
    Route::post('/notifications/{id}/dismiss', 'NotificationController@dismiss');

    // Push Subscriptions
    Route::post('/subscriptions', 'PushSubscriptionController@update');
    Route::post('/subscriptions/delete', 'PushSubscriptionController@destroy');

    Route::get('/search-user', 'UserController@searchUser');
});
