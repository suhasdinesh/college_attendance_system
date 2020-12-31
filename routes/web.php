<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/portal/attendance', 'AttendanceController@index' );
Route::post('/portal/attendance/mark_attendance','AttendanceController@fetch_students');
Route::post('/portal/attendance/done','AttendanceController@take_attendance');
Route::get('/portal/attendance/view','AttendanceController@view');
Route::post('/portal/attendance/view','AttendanceController@fetch_post');
Route::get('/portal/attendance/view/{class}','AttendanceController@fetch');
Route::get('/portal/attendance/view_single','AttendanceController@view2');
Route::get('/portal/attendance/view_single/{class}','AttendanceController@send_student');
Route::post('/portal/attendance/view_single/','AttendanceController@single_student_data');

Route::group(['prefix' => 'portal'], function () {
    Voyager::routes();
});

