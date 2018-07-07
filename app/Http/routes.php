<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'AppController@index')->middleware('guest');
Route::post('login','AppController@postLogin');
Route::post('logout','AppController@logout');
Route::get('dashboard','AppController@dashboard')->middleware('auth');

Route::group(['middleware' => 'auth','prefix'=>'master'], function () {
    Route::resource('karyawan','KaryawanController');
    Route::resource('divisi','DivisiController');
    Route::resource('jabatan','JabatanController');
    Route::resource('jatah-cuti','JatahCutiController');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('cuti','PengajuanCutiController@indexCuti');
	Route::get('pengajuan-cuti/approval','PengajuanCutiController@approval');
	Route::get('pengajuan-cuti/verifikasi','PengajuanCutiController@verifikasi');
	Route::get('pengajuan-cuti/{id}/{status}','PengajuanCutiController@status');
	Route::resource('pengajuan-cuti','PengajuanCutiController');
});
