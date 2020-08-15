<?php

Route::group(['middleware'=>['auth:api']],function(){

    Route::get('/get-classroom-detail/{classroomId}','ClassroomController@getClassroomDetails');
    Route::get('/classroom/{classroomId}/unit-details','ClassroomController@getClassroomUnitDetails');
    Route::post('/classroom/create','ClassroomController@createClassroom');
    Route::post('/classroom/join','ClassroomUserController@joinClassroom');

    Route::get('/classroom/{classroomId}/unit-details','ClassroomController@getUnitAssismentDetails');
    Route::get('/classroom/{classroomId}/daily-questions','DailyQuestionController@getDailyAssismentDetails');
    Route::get('/get-previous-unit-answers','ClassroomController@getPreviousUnitAnswers');
    Route::post('/classroom/{classroomId}/update-unit','ClassroomUnitController@updateUnit');
    Route::post('/classroom/{classroomId}/activate-unit','ClassroomUnitController@activateUnit');
    Route::post('/classroom/{classroomId}/delete-unit','ClassroomUnitController@deleteUnit');

    Route::post('/classroom/{classroomId}/update-daily-questions','DailyAssignmentController@addDailyAssignment');

});