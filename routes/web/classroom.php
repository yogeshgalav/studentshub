<?php

use Illuminate\Support\Facades\Route;
//classroom routes
Route::group(['middleware'=>['AuthorizeUser']],function(){
    //classroom listing
    Route::get('/classrooms', 'ClassroomController@classroomListPage');
    //claasrooom create
    Route::get('/create-classroom','ClassroomController@createClassroomPage');
    //student's info view for teachers
    Route::get('/classroom/{classroomId}/student-panel/{userId?}','ClassroomController@studentPanelPage');
    
    //classrrom pages
    Route::get('/classroom/{classroomId}','ClassroomController@classroomPage');
    Route::get('/classroom/{classroomId}/overview','ClassroomController@classroomOverviewPage');
    Route::get('/classroom/{classroomId}/setup','ClassroomController@classroomSetupPage');
    Route::get('/classroom/{classroomId}/unit-assignment','ClassroomController@classroomUnitAssignmentPage');
    Route::get('/classroom/{classroomId}/daily-assignment','ClassroomController@classroomDailyAssignmentPage');
    Route::get('/classroom/{classroomId}/daily-report','ClassroomController@classroomDailyReportPage');
    Route::get('/classroom/{classroomId}/students','ClassroomController@classroomStudentPage');
    Route::get('/classroom/{classroomId}/resources','ClassroomController@classroomResoucePage');
    Route::get('/classroom/{classroomId}/doubts','ClassroomController@classroomDoubtPage');
    Route::get('/classroom/{classroomId}/messages','ClassroomController@classroomMessagePage');
    //doubts
    Route::get('/doubts','ClassroomController@doubtPage');
    Route::get('/doubt/{id}','classroomController@doubtAnswersPage');
    //student page for unit-attempt
    Route::get('/classroom/{classroomId}/unit-attempt','ClassroomController@unitAttemptPage');
    Route::get('/classroom/{classroomId}/question/{questionId}','ClassroomController@topicAnswersPage');
});