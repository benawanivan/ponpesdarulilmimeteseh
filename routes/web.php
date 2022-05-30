<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/', 'App\Http\Controllers\HomeController@home')->name('home');
Route::get('/berita', 'App\Http\Controllers\HomeController@berita')->name('berita');
Route::get('/detailberita/{id}', 'App\Http\Controllers\HomeController@detailberita');
Route::get('/ecommerce', 'App\Http\Controllers\HomeController@ecommerce')->name('ecommerce');

Route::get('/admin', 'App\Http\Controllers\AdminController@adminlogin')->name('adminlogin')->middleware('CekNoLoginMiddleware');
Route::post('/proseslogin', 'App\Http\Controllers\AdminController@proses_login')->name('proseslogin');

Route::group(['middleware' => 'CekLoginMiddleware'], function (){
    Route::get('/logout', 'App\Http\Controllers\AdminController@logout')->name('logout');
    Route::get('/kelolaberita', 'App\Http\Controllers\AdminController@kelolaberita')->name('kelolaberita');
    Route::get('/tambahberita', 'App\Http\Controllers\AdminController@tambahberita')->name('tambahberita');
    Route::get('/kelolaproduk', 'App\Http\Controllers\AdminController@kelolaproduk')->name('kelolaproduk');
    Route::get('/tambahproduk', 'App\Http\Controllers\AdminController@tambahproduk')->name('tambahproduk');
    Route::post('/upload', 'App\Http\Controllers\AdminController@proses_upload')->name('upload');
    Route::post('/upload2', 'App\Http\Controllers\AdminController@proses_upload2')->name('upload2');
    Route::get('/delete/{id}','App\Http\Controllers\AdminController@destroy');
    Route::get('/delete2/{id}','App\Http\Controllers\AdminController@destroy2');

});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
