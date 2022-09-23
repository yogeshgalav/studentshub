<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
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


require __DIR__.'/auth.php';
