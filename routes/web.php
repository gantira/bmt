<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('simpanan/report', 'SimpananController@report');
    Route::get('simpanan/{id}/struk', 'SimpananController@struk');
    Route::get('pinjaman/report', 'PinjamanController@report');
    Route::get('pinjaman/{id}/struk', 'PinjamanController@struk');
    Route::get('penarikan/report', 'PenarikanController@report');
    Route::get('penarikan/{id}/struk', 'PenarikanController@struk');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('simpanan', 'SimpananController');
    Route::resource('nasabah', 'NasabahController');
    Route::resource('penarikan', 'PenarikanController');
    Route::resource('pinjaman', 'PinjamanController');
    Route::resource('bayar', 'BayarController');
    Route::get('laporan/simpanan', 'LaporanController@simpanan');
    Route::get('laporan/penarikan', 'LaporanController@penarikan');
    Route::get('laporan/pinjaman', 'LaporanController@pinjaman');
    Route::resource('laporan', 'LaporanController');
});

Route::group(['prefix' => 'admin'],function () {
    Route::resource('/users', 'Admin\UserController');
	Route::resource('/roles', 'Admin\RoleController');
	Route::resource('/permissions', 'Admin\PermissionController');
});