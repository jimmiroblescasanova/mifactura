<?php

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

Route::patch('user', 'UserController@update')->name('user.update');
Route::get('user/edit', 'UserController@index')->name('user.edit');

Route::get('documents/{type}', 'DocumentController@index')->name('documents.index');
Route::post('documents/invoices/selected', 'DocumentController@selected')->name('documents.invoice.selected');

Route::post('documents/ajax/download-xml', 'DocumentController@xml')->name('documents.download.xml');
Route::get('documents/{type}/pdf/{guid}', 'DocumentController@pdf')->name('documents.download.pdf');
Route::get('documents/download/{file}', 'DocumentController@download');

Route::get('estados-de-cuenta', 'AccountStatementController@index')->name('account.index');
Route::post('estados-de-cuenta/reporte', 'AccountStatementController@reporte')->name('account.reporte');
Route::post('estados-de-cuenta/excel', 'AccountStatementController@excel')->name('account.excel');

Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/empresa/', 'Admin\DashboardController@index')
        ->name('admin.empresa');
    Route::get('admin/usuarios-registrados/', 'Admin\RegisteredUsersController@index')
        ->name('admin.users');
    Route::post('admin/usuarios-registrados/update', 'Admin\RegisteredUsersController@ChangeAdmin')
        ->name('admin.users.change-admin');
});
