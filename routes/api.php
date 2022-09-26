<?php

use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/post',[App\Http\Controllers\Api\PostController::class, 'create']);
Route::delete('/post',[App\Http\Controllers\Api\PostController::class, 'delete']);
Route::put('/post',[App\Http\Controllers\Api\PostController::class, 'edit']);
Route::post('/classroom',[App\Http\Controllers\Api\ClassroomController::class, 'create']);
Route::delete('/classroom',[App\Http\Controllers\Api\ClassroomController::class, 'delete']);
Route::put('/classroom',[App\Http\Controllers\Api\ClassroomController::class, 'edit']);
Route::post('/comment',[App\Http\Controllers\Api\CommentController::class, 'create']);
Route::put('/comment',[App\Http\Controllers\Api\CommentController::class, 'edit']);
Route::post('/like',[App\Http\Controllers\Api\CommentController::class, 'createordelete']);
Route::post('/classroomfollower',[App\Http\Controllers\Api\ClassroomFollowerController::class, 'create']);
Route::delete('/classroomfollower',[App\Http\Controllers\Api\ClassroomFollowerController::class, 'delete']);