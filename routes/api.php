<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
/*
user api routes
*/    
Route::prefix('user')->group(function () {
    /* GET */
    Route::get('/index', 'UserController@index');
    Route::get('/find', 'UserController@find');
    /* POST */
    Route::post('/login', 'UserController@login');
    Route::post('/register', 'UserController@register');
    /* PUT */
    Route::put('/update', 'UserController@update');
    /* DELETE */
    Route::delete('/destroy', 'UserController@destroy');
});
/*
department api routes
*/
Route::prefix('department')->group(function () {
    /* GET */
    Route::get('/index', 'DepartmentController@index');
    Route::get('/find', 'DepartmentController@find');
    /* POST */
    Route::post('/store', 'DepartmentController@store');
    /* PUT */
    Route::put('/update', 'DepartmentController@update');
    /* DELETE */
    Route::delete('/destroy', 'DepartmentController@destroy');
});
/*
group api routes
*/
Route::prefix('group')->group(function () {
    /* GET */
    Route::get('/index', 'GroupController@index');
    Route::get('/find', 'GroupController@find');
    /* POST */
    /* PUT */
    /* DELETE */
});
/*
patient api routes
*/
Route::prefix('patient')->group(function () {
    /* GET */
    Route::get('/index', 'PatientController@index');
    Route::get('/find', 'PatientController@find');
    /* POST */
    Route::post('/store', 'PatientController@store');
    /* PUT */
    Route::put('/update', 'PatientController@update');
    /* DELETE */
    Route::delete('/destroy', 'PatientController@destroy');
});
/*
appointment api routes
*/
Route::prefix('appointment')->group(function () {
    /* GET */
    Route::get('/index', 'AppointmentController@index');
    Route::get('/find', 'AppointmentController@find');
    /* POST */
    Route::post('/store', 'AppointmentController@store');
    /* PUT */
    Route::put('/update', 'AppointmentController@update');
    Route::put('/status-update', 'AppointmentController@statusUpdate');
    /* DELETE */
    Route::delete('/destroy', 'AppointmentController@destroy');
});
/*
report api routes
*/
Route::prefix('report')->group(function () {
    /* GET */
    Route::get('/index', 'ReportController@index');
});