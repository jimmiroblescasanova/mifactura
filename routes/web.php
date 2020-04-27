<?php

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

Route::get('search', 'SearchController@index');
Route::post('search', 'SearchController@search')->name('search');

Route::patch('user', 'UserController@update')->name('user.update');
Route::get('user/edit', 'UserController@index')->name('user.edit');

Route::get('documents/{type}', 'DocumentController@index')->name('documents.index');
Route::post('documents/invoices/selected', 'DocumentController@selected')->name('documents.invoice.selected');

Route::post('documents/ajax/download-pdf', 'DocumentController@pdf')->name('documents.download.pdf');
Route::post('documents/ajax/download-xml', 'DocumentController@xml')->name('documents.download.xml');
Route::get('documents/download/{file}', 'DocumentController@download');
