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

require_once('web/guest.php');
require_once('web/seeker.php');
require_once('web/student.php');
require_once('web/classroom.php');
require_once('web/admin.php');
Route::get('/', 'PagesController@root');
Route::get('/report', 'PagesController@report');
Route::get('/privacy-policy', 'PagesController@report');
Route::get('/terms-of-service', 'PagesController@report');


Route::get('/post-images/{filename}','PagesController@postImage');
Route::get('/profile-images/{filename}','PagesController@profileImage');
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