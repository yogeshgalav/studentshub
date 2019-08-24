
<?php

Route::post('/submit-post','HomeController@create');
Route::get('/get-posts','HomeController@index');
Route::get('/get-categories','CategoryController@index');
Route::get('/get-subects/{category_id}','SubjectController@index');
