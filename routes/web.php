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

Route::get('/', 'ScheduleController@index');
Route::get('/teacher/{teacher}/', 'ScheduleController@teacher');
Route::get('/auditory/{auditory}/', 'ScheduleController@auditory');

Route::get('/calendar/group/{group}/{format?}', 'ICalController@groupCalendar');
Route::get('/calendar/teacher/{teacher}/{format?}', 'ICalController@teacherCalendar');
