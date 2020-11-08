<?php 

Route::group(['prefix'=>'admin','middleware'=>'admin'],function () {
	Route::get('/dashboard','AdminController@index');
	Route::get('/institutes','AdminController@institutes');
	Route::get('/students','AdminController@show');
	Route::get('/show_post/{id}','AdminController@getPost');
	Route::get('/show_details_post/{id}','AdminController@getPostDetails');
	Route::post('/blockUpdate','AdminController@blockUpdate');
	Route::post('/unblockUpdate','AdminController@unblockUpdate');


	Route::get('/explorePost','AdminController@explorePost');

	Route::get('/Posts/{postType}','AdminController@topPost');
	Route::get('/replace_post/{postType}','AdminController@replace_post');
	Route::get('/new_post_id/{newPostId}/old_post_id/{currentPostId}','AdminController@updatePost');
});