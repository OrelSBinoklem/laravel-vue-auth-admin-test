<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'UserController@get');

    Route::group(['middleware' => 'verified'], function () {
        Route::patch('settings/profile', 'Settings\ProfileController@update');
        Route::patch('settings/password', 'Settings\PasswordController@update');
    });

    Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'verified'], function () {
        Route::get('users/get-table', 'UsersController@getTableData');
        Route::patch('users/group-ban', 'UsersController@groupBan');
        Route::patch('users/group-delete', 'UsersController@groupDelete');
        Route::resource('users', 'UsersController', ['only' => ['store', 'update', 'destroy']]);

        Route::get('roles/get-table', 'RolesController@getTableData');
        Route::get('roles/get-permission-role-table', 'RolesController@getPermissionRoleTableData');
        Route::patch('roles/change-permission-role', 'RolesController@changePermissionRole');
        Route::resource('roles', 'RolesController', ['only' => ['store', 'update', 'destroy']]);
    });
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
