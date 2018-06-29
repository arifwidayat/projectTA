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

Route::get('/', 'AppController@index');

Route::group(['middleware'=>'auth','prefix'=>'master'], function () {
    Route::resource('karyawan','KaryawanController');
    Route::resource('divisi','DivisiController');
    Route::resource('jatah-cuti','JatahCutiController');
});

Route::resource('pengajuan-cuti','PengajuanCutiController');