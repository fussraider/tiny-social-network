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

Route::post('login', 'AuthController@login')->name('user.login');
Route::post('register', 'AuthController@register')->name('user.register');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'AuthController@logout')->name('user.logout');
    Route::get('refresh', 'AuthController@refresh')->name('user.refresh');

    Route::group(['prefix' => 'user'], function (){
        Route::get('/', 'UserController@index')->name('user.data');
        Route::get('{user_id}', 'UserController@index');
        Route::get('{user_id}/{entity}_list', 'EntityController@userEntityList')->name('user.entities');
    });

    Route::get('{entity}_list', 'EntityController@index')->name('entity.all');
    Route::group(['prefix' => '{entity}'], function (){
        Route::get('{entity_id}', 'EntityController@entity')->name('entity.single');
        Route::put('{entity_id}/like', 'EntityController@like')->name('entity.like');
    });

    Route::match(['put', 'post'], 'publish', 'EntityController@publish')->name('entity.publish');
    Route::match(['put', 'post'], 'update', 'EntityController@update')->name('entity.update');
    Route::delete('{entity}', 'EntityController@delete')->name('entity.delete');



});
