<?php  

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth','admin']],function(){
    Route::get('/leads', 'StaffController@leadIndexPage');
    Route::get('/lead/{lead}', 'StaffController@leadShowPage');
    Route::get('/manage-courses', 'StaffController@manageCoursePage');
    Route::get('/manage-jobs', 'StaffController@manageJobsPage');
    Route::get('/user-feedbacks', 'StaffController@userFeedbacksPage');
    Route::get('/user-reports', 'StaffController@userReportsPage');
    Route::get('/transaction-details', 'StaffController@transactionDetailsPage');
});