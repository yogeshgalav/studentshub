<?php

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

Route::group(['middleware'=>['auth',]],function(){
    require_once('web/auth_routes.php');
});

Route::get('/login','PagesController@loginPage');
Route::get('/get-started','PagesController@registerPage');
Route::get('/forgot-password','PagesController@forgotPassword')->name('forgot-password');
Route::get('/reset-password/{token}','PagesController@resetPassword');
Route::get('/logout','AuthController@logout');

Route::get('/', 'PagesController@root');
Route::get('/post/{ViewPostId}', 'PagesController@viewPost');
Route::get('/explore', 'PagesController@explore');

// Localization
Route::get('/js/lang.js', function () {
    $strings = Cache::remember('lang.js',1, function () {
        $lang = config('app.locale');

        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            /** @noinspection PhpIncludeInspection */
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo('window.lang = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');