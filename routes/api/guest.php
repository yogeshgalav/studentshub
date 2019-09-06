<?php



Route::post('/subscribe','GuestController@update');
Route::get('/get-post-content/{post_id}','PostViewController@index');