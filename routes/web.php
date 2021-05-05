<?php

use App\Http\Controllers\AccountController;
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

//Home page
Route::get('/', function () {
    return view('index');
});
//Home page

//Attendance Model start.
Route::get('/portal/attendance', 'AttendanceController@index' );
Route::post('/portal/attendance/mark_attendance','AttendanceController@fetch_students');
Route::post('/portal/attendance/done','AttendanceController@take_attendance');
Route::get('/portal/attendance/view','AttendanceController@view');
Route::post('/portal/attendance/view','AttendanceController@fetch_post');
Route::get('/portal/attendance/view/{class}','AttendanceController@fetch');
Route::get('/portal/attendance/view_single','AttendanceController@view2');
Route::get('/portal/attendance/view_single/{class}','AttendanceController@send_student');
Route::post('/portal/attendance/view_single','AttendanceController@single_student_data');
Route::get('/portal/attendance/class_wise','AttendanceController@class_wise');
Route::post('/portal/attendance/class_wise','AttendanceController@class_wise_data');
//Attendance Model end.

//Internal Assessment Model start.
Route::get('/portal/internal_assessments','InternalAssessmentController@index');
Route::get('/portal/internal_assessment/{class_id}','InternalAssessmentController@send_data');
Route::post('/portal/internal_assessments','InternalAssessmentController@fetch_dataRow');
Route::post('/portal/internal_assessments/store','InternalAssessmentController@store_dataRow');
Route::get('/portal/internal_assessments/classwise','InternalAssessmentController@classwiseindex');
Route::get('/portal/internal_assessments/classwise#{class_id}','InternalAssessmentController@classwise_getDataRows');
//Internal Assessment Model end.

//User Approval Model start.
Route::get('/portal/approve_user','UserableController@index');
Route::post('/portal/approve_user','UserableController@create');
//User Approval Model end.

//Account Managment start.
Route::get('/register','AccountController@index');
Route::post('/register','AccountController@store');
//Account Managment end.


// Route::get('/admin',function(){
//     return redirect('/portal');
// });
Route::group(['prefix' => 'portal'], function () {
    Voyager::routes();
});

