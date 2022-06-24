
<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/posts', [App\Http\Controllers\Api\PostController::class, 'getPosts']);

    Route::get('{dashboard_type}/{dashboard_id}/doubts', [App\Http\Controllers\Api\DoubtController::class, 'getDoubts']);
    Route::get('/doubts', [App\Http\Controllers\Api\DoubtController::class, 'getDoubts']);
    
    Route::post('/{likable_type}/{likable_id}/like', 'LikeController@updateOrDelete');
    Route::post('/{votable_id}/vote', 'VoteController@updateOrDelete');
    Route::post('/post-save', 'PostController@savePost');
    Route::post('/post-report', 'PostController@reportPost');
    Route::delete('post/{post}', 'PostController@delete');
        //profile
    Route::get('/get-profile','UserController@getProfile');
    Route::post('/{followable_id}/follow','FollowController@updateOrDelete');
    Route::post('/save-profile', 'UserController@saveProfile');
    Route::post('/save-institute-profile', 'UserController@saveInstiProfile');
    Route::delete('/delete-teachersdetails/{teacher}','UserController@deleteTeacherDetails');
    Route::delete('/delete-studentdetails/{student}','UserController@deleteStudentDetails');
    Route::post('/checkin/student', [App\Http\Controllers\Api\StudentController::class, 'create']);
    Route::post('/checkin/teacher', 'InstituteUserController@teacherCheckin');
    Route::get('/search-user', [App\Http\Controllers\Api\SearchController::class, 'searchUser']);

    // Notifications
    Route::get('/notifications', 'NotificationController@index');

    // Push Subscriptions
    Route::post('/subscriptions', 'PushSubscriptionController@update');
    Route::post('/subscriptions/delete', 'PushSubscriptionController@destroy');

    //comments
    Route::put('/comment/{comment}','CommentController@update');
    Route::delete('/comment/{comment}','CommentController@delete');
   
    Route::post('/{commentable_type}/{commentable_id}/add-comment', 'CommentController@create');

    Route::put('/preferred-details', 'UserController@setPreferredDetails');
});
