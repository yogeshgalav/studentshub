<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
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
require_once('web/institute.php');
require_once('web/staff.php');

Route::get('/', 'GuestController@root');
Route::get('/report', 'GuestController@report');
Route::get('/privacy-policy', 'GuestController@privacyPolicy');
Route::get('/terms-of-service', 'GuestController@termOfUse');

// Manifest file (optional if VAPID is used)
Route::get('manifest.json', function () {
    return [
        'name' => config('app.name'),
        'gcm_sender_id' => config('webpush.gcm.sender_id')
    ];
});

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

Route::get('/schedule-jobs', function () {
    \Artisan::call('sthub:cron');
    // \Artisan::call('schedule:run');
});