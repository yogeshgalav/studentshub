<?php

use Illuminate\Http\Request;

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
require_once('api/guest.php');
require_once('api/student.php');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login','AuthController@login');
Route::post('/forgot-password','AuthController@processForgotPassword');
Route::post('/reset-password','AuthController@resetPassword');
Route::get('/get-view-post/{ViewPostId}', 'PostController@viewPost');
Route::get('/get-explore-posts', 'ExploreController@index');
