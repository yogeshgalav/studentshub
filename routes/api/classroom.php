<?php

Route::group(['middleware'=>['auth:api']],function(){

    Route::get('/get-classroom-detail/{classroomId}','ClassroomController@getClassroomDetails');
    Route::get('/classroom/{classroomId}/unit-details','ClassroomUnitController@getClassroomUnitDetails');
    Route::post('/classroom/create','ClassroomController@createClassroom');
    Route::post('/classroom/join','ClassroomUserController@joinClassroom');
    Route::post('/classroom/accept','ClassroomUserController@acceptJoinRequest');

    Route::get('/classroom/{classroomId}/unit-assignment-details','ClassroomUnitController@getUnitAssismentDetails');
    Route::get('/get-previous-unit-answers','ClassroomController@getPreviousUnitAnswers');
    Route::post('/classroom/{classroomId}/update-unit','ClassroomUnitController@updateUnit');
    Route::post('/classroom/{classroomId}/activate-unit','ClassroomUnitController@activateUnit');
    Route::post('/classroom/{classroomId}/delete-unit','ClassroomUnitController@deleteUnit');

    Route::get('/classroom/{classroomId}/daily-questions','DailyAssignmentController@getDailyAssismentDetails');
    Route::post('/update-daily-assignment','DailyAssignmentController@updateDailyAssignment');
    Route::post('/update-daily-question','DailyAssignmentController@updateDailyQuestion');

});