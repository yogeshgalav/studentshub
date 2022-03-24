<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:api']],function(){
    Route::get('/leads','LeadController@index');
    Route::post('/add-job','CareerController@createOrUpdate');
    Route::delete('/job/{job}','CareerController@delete');
});