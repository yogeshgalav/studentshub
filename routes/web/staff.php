<?php  

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['auth']],function(){
    Route::get('/leads', 'StaffController@leadsPage');
});