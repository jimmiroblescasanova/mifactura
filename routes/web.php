<?php

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

Route::get('search', 'SearchController@index');
Route::post('search', 'SearchController@search')->name('search');

Route::patch('user', 'UserController@update')->name('user.update');
Route::get('user/edit', 'UserController@index')->name('user.edit');

Route::get('documents/{type}', 'DocumentController@index')->name('documents.index');
Route::post('documents/invoices/selected', 'DocumentController@selected')->name('documents.invoice.selected');

Route::get('documents/ajax/download-pdf/{guid}', 'DocumentController@pdf')->name('documents.download.pdf');
Route::get('documents/ajax/test/{guid}', 'DocumentController@test')->name('documents.download.test');
Route::post('documents/ajax/download-xml', 'DocumentController@xml')->name('documents.download.xml');
Route::get('documents/download/{file}', 'DocumentController@download');
