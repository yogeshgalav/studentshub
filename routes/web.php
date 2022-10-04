<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ClassroomFollowerController;
use App\Http\Controllers\LikeController;
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
Route::get('/post-create', [PostController::class, 'create']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/classroom-create', [ClassroomController::class, 'create']);
Route::get('/classrooms', [ClassroomController::class, 'index']);
Route::get('/classroom/{id}', [ClassroomController::class, 'show']);

// Route::get('/post-create', [PostController::class, 'create']);



require __DIR__.'/auth.php';
