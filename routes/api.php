<?php


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

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'users', 'namespace' => 'User'], function () {
        // Authentication routes
        Route::post('/login', 'AuthController@login');
        Route::get('/logout', 'AuthController@logout');
        Route::post('/register', 'AuthController@register');
    });

    Route::group(['prefix' => 'admins', 'namespace' => 'Admin', 'middleware' => ['apiAuth', 'isAdmin']], function () {
        // User management routes
        Route::post('/users', 'UserController@create');
        Route::get('/users', 'UserController@index');
        Route::delete('/users/{user}', 'UserController@delete');

        // Group management routes
        Route::post('/groups', 'GroupController@create');
        Route::get('/groups', 'GroupController@index');
        Route::get('/groups/{group}/user/{user}', 'GroupController@attach');
        Route::delete('/groups/{group}/user/{user}', 'GroupController@detach');
        Route::delete('/groups/{group}', 'GroupController@delete');
    });

});
