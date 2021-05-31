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
    Route::get('/classroom/{classroomId}/attendance','ClassroomController@classroomAttendancePage');
    Route::get('/classroom/{classroomId}/setup','ClassroomController@classroomSetupPage');
    Route::get('/classroom/{classroomId}/daily-assignment','ClassroomController@classroomDailyAssignmentPage');
    Route::get('/classroom/{classroomId}/report','ClassroomController@classroomStudentPage');
    Route::get('/classroom/{classroomId}/resources','ClassroomController@classroomResoucePage');
    Route::get('/classroom/{classroomId}/doubts','ClassroomController@classroomDoubtPage');
    Route::get('/classroom/{classroomId}/messages','ClassroomController@classroomMessagePage');
    //doubts
    Route::get('/doubts','ClassroomController@doubtPage');
    Route::get('/doubt/{id}','ClassroomController@doubtAnswersPage');
    Route::get('/messages', 'ClassroomController@GlobalMessagePage');
    
    Route::get('/my-reports','ClassroomController@myReports');

});