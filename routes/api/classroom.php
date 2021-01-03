<?php

Route::group(['middleware'=>['auth:api']],function(){

    Route::post('/classroom/create','ClassroomController@createClassroom');
    Route::post('/classroom/join','ClassroomUserController@joinClassroom');
    Route::get('/get-classroom-detail/{classroomId}','ClassroomController@getClassroomDetails');
    //overview
    Route::post('/classroom/{classroomId}/update-detail','ClassroomController@update');
    Route::delete('/classroom/{classroomId}/delete','ClassroomController@delete');
    //unit setup
    Route::get('/classroom/{classroomId}/unit-details','ClassroomUnitController@getClassroomUnitDetails');
    //students    
    Route::get('/classroom/{classroomId}/students-data','ClassroomUserController@getClassrromUserData');
    //student join request
    Route::post('/classroom/user-request-action','ClassroomUserController@userRequestAction');
    //unit assignment
    Route::get('/classroom/{classroomId}/unit-assignment-details','ClassroomUnitController@getUnitAssismentDetails');
    Route::get('/get-previous-unit-answers','ClassroomController@getPreviousUnitAnswers');
    Route::post('/classroom/{classroomId}/update-unit','ClassroomUnitController@updateUnit');
    Route::post('/classroom/{classroomId}/activate-unit','ClassroomUnitController@activateUnit');

    Route::get('/classroom/{classroomId}/daily-questions','DailyAssignmentController@getDailyAssismentDetails');
    Route::get('/classroom/{classroomId}/daily-assignment-reports','DailyAssignmentController@getDailyAssismentReports');
    Route::post('/update-daily-assignment','DailyAssignmentController@updateDailyAssignment');
    Route::post('/activate-daily-assignment','DailyAssignmentController@activateDailyAssignment');
    Route::post('/delete-daily-assignment','DailyAssignmentController@deleteDailyAssignment');
    
    Route::post('/classroom/update-daily-question','DailyQuestionController@updateDailyQuestion');
    Route::post('/classroom/delete-daily-question','DailyQuestionController@deleteDailyQuestion');
    //student daily assignment page
    Route::get('/classroom/{classroomId}/get-todays-report','DailyReportController@getTodaysReport');
    //student panel
    Route::get('/classroom/{classroomId}/get-student-daily-reports/{userId?}','DailyReportController@getDailyReports');
    Route::post('/classroom/{classroomId}/get-daily-answers','DailyReportController@getDailyAnswers');
    
});