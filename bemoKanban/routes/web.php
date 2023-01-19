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

Route::get('/home', function () {
    return redirect()->route('cards.index');
})->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('cards', 'CardController@index')->name('cards.index');
    Route::post('cards', 'CardController@store')->name('cards.store');
    Route::put('cards/sync', 'CardController@sync')->name('cards.sync');
    Route::put('cards/{card}', 'CardController@update')->name('cards.update');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('statuses', 'StatusController@store')->name('statuses.store');
    Route::put('statuses', 'StatusController@update')->name('statuses.update');
});
