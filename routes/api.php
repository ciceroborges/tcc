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
    Route::get('/all', 'DepartmentController@all');
    /* POST */
    /* PUT */
    /* DELETE */
});
/*
department api routes
*/
Route::prefix('group')->group(function () {
    /* GET */
    Route::get('/all', 'GroupController@all');
    /* POST */
    /* PUT */
    /* DELETE */
});
