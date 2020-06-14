<?php

Route::group(['middleware'=>['auth']],function(){
    //post routes
    
    Route::get('/classroom/{classroomId}','ClassroomController@classroomPage');
    Route::get('/classroom/{classroomId}/student-panel/{userId}','ClassroomController@studentPanelPage');
    Route::get('/classroom/{classroomId}/topic/{topicId}','ClassroomController@topicAnswersPage');
});