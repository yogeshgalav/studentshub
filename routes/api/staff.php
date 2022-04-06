<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth:api']],function(){
    Route::get('/leads','LeadController@index');
    Route::post('/lead/{userId}','LeadController@createOrUpdate');
    Route::post('/career','CareerController@createOrUpdate');
    Route::delete('/career/{career}','CareerController@delete');
    Route::get('/membership','MembershipController@index');
});