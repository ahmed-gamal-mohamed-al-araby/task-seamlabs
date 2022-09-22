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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/show','Api\AllController@showUser');
Route::post('login','Api\AllController@login');
Route::post('register','Api\AllController@Register');
Route::get('users','Api\AllController@allUser');
Route::post('user/update','Api\AllController@updateUser');
Route::get('logout','Api\AllController@logout');
Route::post('count-number','Api\AllController@countNumber');
Route::post('index-string','Api\AllController@indexString');
Route::post('count-minimum-steps','Api\AllController@countMinimumSteps');
