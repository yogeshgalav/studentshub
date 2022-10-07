<?php

use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ClassroomController;

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


Route::post("/verify-contact",[AuthController::class, 'verifyContact']);
Route::post("/login",[AuthController::class, 'loginViaOtp'])->name('login');
Route::post("/register",[AuthController::class, 'registerViaOtp']);



Route::get('/post/{id}', [PostController::class, 'show']);
Route::get('/post-create', [PostController::class, 'create']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/classroom-create', [ClassroomController::class, 'create']);
Route::get('/classrooms', [ClassroomController::class, 'index']);
Route::get('/classroom/{id}', [ClassroomController::class, 'show']);

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