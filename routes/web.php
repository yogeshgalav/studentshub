<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ClassroomController;
use App\Http\Controllers\Api\ClassroomFollowerController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('/');
Route::get('/post/{id}', [PostController::class, 'show']);

Route::get('home', [HomeController::class, 'index'])->name('home');
Route::resource('employee', EmployeeController::class)->only(['index', 'store', 'update', 'destroy']);

// Route::get('/post-create', [PostController::class, 'create']);

Route::post('/post-create',[App\Http\Controllers\Api\PostController::class, 'create']);
Route::post('/post-delete',[App\Http\Controllers\Api\PostController::class, 'delete']);
Route::post('/post-edit',[App\Http\Controllers\Api\PostController::class, 'edit']);
Route::post('/classroom-create',[App\Http\Controllers\Api\ClassroomController::class, 'create']);
Route::post('/classroom-delete',[App\Http\Controllers\Api\ClassroomController::class, 'delete']);
Route::post('/classroom-edit',[App\Http\Controllers\Api\ClassroomController::class, 'edit']);
Route::post('/comment-create',[App\Http\Controllers\Api\CommentController::class, 'create']);
Route::post('/comment-edit',[App\Http\Controllers\Api\CommentController::class, 'edit']);
Route::post('/like-create',[App\Http\Controllers\Api\CommentController::class, 'create']);
Route::post('/like-delete',[App\Http\Controllers\Api\CommentController::class, 'delete']);
Route::post('/classroomfollower-create',[App\Http\Controllers\Api\ClassroomFollowerController::class, 'create']);
Route::post('/classroomfollower-delete',[App\Http\Controllers\Api\ClassroomFollowerController::class, 'delete']);


require __DIR__.'/auth.php';
