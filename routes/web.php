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

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/dashboard', 'HomeController@dashboard')->name('admin.dashboard');

//  Album

    Route::get('/albums', 'AlbumController@index')->name('admin.albums');
    Route::get('/add-album', 'AlbumController@create')->name('admin.create.albums');
    Route::post('/add-album', 'AlbumController@store')->name('admin.store.albums');
    Route::get('/edit-album/{id}', 'AlbumController@edit')->name('admin.edit.albums');
    Route::post('/update-album/{id}', 'AlbumController@update')->name('admin.update.albums');
    Route::get('/delete-album/{id}', 'AlbumController@delete')->name('admin.delete.albums');

});


