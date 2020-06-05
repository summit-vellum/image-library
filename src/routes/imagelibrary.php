<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the ArticleServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'web'], function() {

	Route::group(['prefix' => '/image-library/feed'], function () {
		Route::get('/', '\Quill\ImageLibrary\Http\Controllers\ImageLibraryController@index')->name('imagelibrary.feed');
    	Route::put('/{id}', '\Quill\ImageLibrary\Http\Controllers\ImageLibraryController@update')->where(['id'=>'([0-9]+)']);
    	Route::delete('/{id}', '\Quill\ImageLibrary\Http\Controllers\ImageLibraryController@destroy')->where(['id'=>'([0-9]+)'])->name('imagelibrary.destroy');
    	Route::post('/', '\Quill\ImageLibrary\Http\Controllers\ImageLibraryController@store');
	});

});
