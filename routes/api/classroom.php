<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClassroomMessageController;
use App\Http\Controllers\Api\ClassroomController;

Route::group(['middleware'=>['auth:api']],function(){
    //classroom common routes
    Route::get('/get-classroom-detail/{classroomId}','ClassroomController@getClassroomDetails');

    //teacher classroom routes
    Route::post('/classroom/create','ClassroomController@createClassroom');
    Route::post('/classroom/{classroom}/update-detail',[App\Http\Controllers\Api\ClassroomController::class, 'update']);
    Route::delete('/classroom/{classroomId}/delete','ClassroomController@delete');
    //unit setup
    Route::get('/classroom/{classroomId}/unit-details','ClassroomUnitController@getClassroomUnitDetails');
    Route::post('/classroom/{classroom}/update-unit',[App\Http\Controllers\Api\ClassroomUnitController::class, 'updateUnit']);
    // Route::post('/classroom/{classroomId}/activate-unit','ClassroomUnitController@activateUnit');

    //daily-assignment routes for teachers
    Route::post('/classroom/{classroom}/create-assignment',[App\Http\Controllers\Api\DailyAssignmentController::class, 'create']);
    Route::post('/daily-assignment/{daily_assignment}/update',[App\Http\Controllers\Api\DailyAssignmentController::class, 'update']);
    Route::post('/daily-assignment/{daily_assignment}/activate','DailyAssignmentController@activate');
    Route::delete('/daily-assignment/{daily_assignment}','DailyAssignmentController@delete');
    Route::get('/classroom/{classroomId}/get-assignment-list','DailyAssignmentController@getAssignmentList');
    Route::get('/classroom/{classroom}/get-attempted-assignment-list','DailyAssignmentController@getAttempedAssignmentList');
    Route::get('/classroom/{classroomId}/assignment/{assignmentId}/reports','ReportController@getQuestionsReports');
    Route::get('/classroom/{classroomId}/assignment/{assignmentId}/questions','DailyQuestionController@getAssignmentQuestions');
    Route::get('/classroom/{classroomId}/daily-assignments-summary','DailyAssignmentController@getDailyAssignmentSummary');
    ///question routes
    Route::post('/classroom/update-daily-question',[App\Http\Controllers\Api\DailyQuestionController::class, 'update']);
    Route::post('/classroom/delete-daily-question','DailyQuestionController@delete');
   //resources
    Route::get('/classroom/{classroomId}/get-resources','ClassroomResourceController@listresource');
    Route::post('/classroom/{classroomId}/add-resource',[App\Http\Controllers\Api\ClassroomResourceController::class, 'addresource']);
    Route::put('/resource/{resource}','ClassroomResourceController@edit');
    Route::delete('/resource/{resource}','ClassroomResourceController@delete');
    //messages
    Route::get('/get-classroom-messages/{classroomId?}',[ClassroomMessageController::class,'listmessage']);
    Route::post('/add-message',[ClassroomMessageController::class, 'addmessage']);
    Route::post('/delete-message',[ClassroomMessageController::class, 'deletemessage']);
    Route::post('/edit-message', [ClassroomMessageController::class, 'editmessage']);

    //student classroom routes
    Route::post('/classroom/join',[ClassroomController::class, 'joinClassroom']);
    Route::get('/classroom/{classroomId}/report','ReportController@getClassroomReport');
    Route::get('/assignment/{daily_assignment}/user/{user?}','ReportController@getAnswerReport');
    Route::post('/classroom/user-request-action','ClassroomStudentController@userRequestAction');

    //student panel
    Route::get('/classroom/{classroomId}/get-assignment-report/{userId?}','ReportController@getAssignmentReport');
    Route::get('/classroom/{classroomId}/get-student-report/{userId?}','ReportController@getStudentReport');
    Route::post('/decline-attempt/{assignmentId}','DailyReportController@declineAttempt');
    
    Route::get('/classroom-list-details','ClassroomController@classroomListDetails');
    

    //attendance
    Route::get('/classroom/{classroomId}/start-meeting','AttendanceController@startMeeting');
    Route::get('/classroom/{classroomId}/join-meeting','AttendanceController@joinMeeting');
    Route::get('/classroom/{classroomId}/start-attendance','AttendanceController@startAttendance');
    Route::get('/classroom/{classroomId}/mark-present','AttendanceController@markPresent');
    Route::get('/classroom/{classroomId}/get-attendance-data','AttendanceController@getAttendanceData');
    Route::get('/classroom/{classroomId}/get-attendance-dates','AttendanceController@getAttendanceDates');
    Route::get('/classroom/{classroomId}/get-student-attendance','AttendanceController@getStudentAttendance');

    //classmates
    Route::get('/classmates','ClassroomController@getClassmatesDetails');

    //homework
    Route::get('/classroom/{classroom}/homeworks','HomeworkController@index');
    Route::get('/classroom/{classroom}/homework/{homework}','HomeworkController@show');
    Route::post('/homework/{homework}/mark-as-done','HomeworkController@markAsDone');
    Route::post('/classroom/{classroom}/homework','HomeworkController@create');

});