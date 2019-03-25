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
Route::get('/attendance','ExecutiveController@attendance')->name('attendance');
Route::get('/dailyattendance','ExecutiveController@dailyattendance')->name('dailyattendance');
Route::get('/present','ExecutiveController@present')->name('present');
Route::get('/Absent','ExecutiveController@Absent')->name('Absent');