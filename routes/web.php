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
Route::get('/vnpay/payment', 'AdminController@index')->name('payment.form');
Route::post('/vnpay/payment', 'AdminController@payment')->name('payment');
Route::get('/vnpay/return', 'AdminController@result')->name('return');
// momo

Route::get('/momo/payment','MomoController@index')->name('momo.payment.form');
Route::post('/momo/payment', 'MomoController@payment')->name('momo.payment');
