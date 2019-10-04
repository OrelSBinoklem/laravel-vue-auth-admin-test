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
        Route::resource('roles', 'RolesController', ['only' => ['index', 'store', 'update', 'destroy']]);

        Route::get('permissions/get-table', 'PermissionsController@getTableData');
        Route::resource('permissions', 'PermissionsController', ['only' => ['store', 'update', 'destroy']]);

        Route::resource('menus', 'MenusController', ['only' => ['index', 'store', 'update', 'destroy']]);
        Route::get('menus/{id_menu}/items', 'MenusController@getItems')->where('id_menu', '[0-9]+');
        Route::post('menus/{id_menu}/items', 'MenusController@storeItem')->where('id_menu', '[0-9]+');
        //todo-mark был put но php непотдерживает сохранение файлов этим методом а хаком https://gist.github.com/Stunext/9171b7a8f3633b0b601a0feb8088dca1 нестал пользоваться
        Route::post('menus/{id_menu}/items/{id_item}', 'MenusController@updateItem')->where(['id_menu' => '[0-9]+', 'id_item' => '[0-9]+']);
        Route::put('menus/{id_menu}/items-update-tree', 'MenusController@updateTreeItems')->where('id_menu', '[0-9]+');
        Route::delete('menus/{id_menu}/items/{id_item}', 'MenusController@deleteItem')->where(['id_menu' => '[0-9]+', 'id_item' => '[0-9]+']);

        Route::put('categories/items-update-tree', 'CategoryController@updateTreeItems');
        Route::resource('categories', 'CategoryController', ['only' => ['index', 'store', 'update', 'destroy']]);
        Route::resource('tags', 'TagsController', ['only' => ['index', 'store', 'update', 'destroy']]);

        Route::group(['prefix' => 'content'], function () {
            Route::get('js-plugin/get-table', 'ContentJSPluginController@getTableData');
            Route::get('js-plugin/get-one', 'ContentJSPluginController@getOne');
            //todo-mark был put но php непотдерживает сохранение файлов этим методом а хаком https://gist.github.com/Stunext/9171b7a8f3633b0b601a0feb8088dca1 нестал пользоваться
            Route::post('js-plugin/{id}', ['uses' => 'ContentJSPluginController@update', 'as' => 'js-plugin.update']);
            Route::resource('js-plugin', 'ContentJSPluginController', ['only' => ['store', 'destroy']]);
        });
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

Route::get('menus/{slug}', 'MenusController@index')->where('slug', '[0-9a-zA-Z\-\_]+');

Route::group(['prefix' => 'content', 'namespace' => 'Content'], function () {
    Route::get('/get-some-items', 'ContentController@getPublicWhereInSlug');
    Route::get('/get-short-by-tax', 'ContentController@ShortWhereInSlugsByTax');
    //plain-plugins-mega-menu
    Route::get('/get-items-ppmm', 'ContentController@getMaterialsDataForItemsPPMM');

    Route::get('js-plugin', 'ContentJSPluginController@index');
});
