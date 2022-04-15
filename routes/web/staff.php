<?php  

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth','admin']],function(){
    Route::get('/manage-users', 'StaffController@leadIndexPage');
    Route::get('/user-details/{user}', 'StaffController@leadShowPage');
    Route::get('/manage-courses', 'StaffController@manageCoursePage');
    Route::get('/manage-jobs', 'StaffController@manageJobsPage');
    Route::get('/user-feedbacks', 'StaffController@userFeedbacksPage');
    Route::get('/user-reports', 'StaffController@userReportsPage');
    Route::get('/transaction-details', 'StaffController@transactionDetailsPage');
    Route::get('/membership-details', 'StaffController@mebershipDetailsPage');
    Route::get('/institutes','StaffController@institutes');

});
