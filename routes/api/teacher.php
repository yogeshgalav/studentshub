<?php

Route::get('/classroom/{classroomId}/unit-details','ClassroomController@getClassroomUnitDetails');
Route::get('/classroom/create','ClassroomController@createClassroom');
Route::get('/classroom/join','ClassroomController@joinClassroom');