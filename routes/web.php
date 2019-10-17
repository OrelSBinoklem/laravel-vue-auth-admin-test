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

/*Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');*/

Route::group(['prefix' => config('commands.settings.route', 'niceartisan')], function () {
    Route::get('/{option?}', '\Bestmomo\NiceArtisan\Http\Controllers\NiceArtisanController@show')
        ->name('niceartisan');
    Route::post('item/{class}', '\Bestmomo\NiceArtisan\Http\Controllers\NiceArtisanController@command')
        ->name('niceartisan.exec');
});

Route::view('{path}', 'index')->where('path', '(.*)');
