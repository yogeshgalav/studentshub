<?php
//classroom routes
Route::group(['middleware'=>['auth']],function(){
    Route::get('/classrooms', 'ClassroomController@classroomListPage');
    Route::get('/classroom/{classroomId}','ClassroomController@classroomPage');
    Route::get('/classroom/{classroomId}/unit-attempt','ClassroomController@unitAttemptPage');
    Route::get('/create-classroom','ClassroomController@createClassroomPage');
    Route::get('/classroom/{classroomId}/student-panel/{userId}','ClassroomController@studentPanelPage');
    Route::get('/classroom/{classroomId}/topic/{topicId}','ClassroomController@topicAnswersPage');
});