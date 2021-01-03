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
require_once('web/institute.php');
Route::get('/', 'PagesController@root');
Route::get('/report', 'PagesController@report');
Route::get('/privacy-policy', 'PagesController@privacyPolicy');
Route::get('/terms-of-service', 'PagesController@termOfUse');


Route::get('/post-images/{filename}','PagesController@postImage');
Route::get('/profile-images/{filename}','PagesController@profileImage');


// Notifications
Route::get('notifications', 'NotificationController@index');
Route::patch('notifications/{id}/read', 'NotificationController@markAsRead');
Route::post('notifications/mark-all-read', 'NotificationController@markAllRead');
Route::post('notifications/{id}/dismiss', 'NotificationController@dismiss');

// Push Subscriptions
Route::post('subscriptions', 'PushSubscriptionController@update');
Route::post('subscriptions/delete', 'PushSubscriptionController@destroy');

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