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

Route::prefix('user')->group(function () {
    //
    
    /* Auth */
    Route::post('/login', 'UserController@login');
    Route::post('/register', 'UserController@register');
    /* GET */
    Route::get('/all', 'UserController@all');
    /*
    //update
    Route::put('', 'Admin_ba_groupController@update');
    //edit 
    Route::get('/{id}', 'Admin_ba_groupController@show');
    //delete
    Route::delete('', 'Admin_ba_groupController@delete');
    */
});
