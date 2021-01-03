<?php

Route::group(['middleware'=>['auth']],function(){
    //post routes
    Route::get('/share-your-knowledge','PagesController@sharePost');
    Route::get('/create-post','PagesController@createPost');
    Route::get('/edit-post','PagesController@editPost');
            
    Route::get('/doubts','DoubtController@indexPage');
    Route::get('/doubt/{id}','DoubtAnswersController@getDoubtAnswersPage');
});