<?php  

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth','admin']],function(){
    Route::get('/leads', 'StaffController@leadIndexPage');
    Route::get('/lead/{userId}', 'StaffController@leadShowPage');
    Route::get('/manage-courses', 'StaffController@manageCoursePage');
    Route::get('/manage-jobs', 'StaffController@manageJobsPage');
    Route::get('/user-feedbacks', 'StaffController@userFeedbacksPage');
    Route::get('/user-reports', 'StaffController@userReportsPage');
});