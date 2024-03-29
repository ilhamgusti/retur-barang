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


Route::post('/register', 'AuthController@register')->name('user.register');
Route::post('/login', 'AuthController@login')->name('user.login');
Route::post('/logout', 'AuthController@logout')->middleware('auth:sanctum')->name('user.logout');
Route::get('/me', 'AuthController@me')->middleware('auth:sanctum')->name('user.me');
Route::put('/me', 'API\UserController@update')->middleware('auth:sanctum')->name('user.update');
Route::get('/artisan', 'ArtisanCallController@index');

Route::group([
    'middleware'    => ['auth:sanctum'],
    'namespace'  => 'API',
    // 'prefix'     => 'reports',
    // 'as' => 'api.'
],function () {
    Route::apiResource('customers', 'CustomerController', ['except' => ['update','show','destroy']]);
    Route::apiResource('users', 'UserController', ['only' => ['index','destroy']]);
    // Route::match(['PUT', 'PATCH'], 'panti', [PantiController::class, 'update'])->name('panti.update');
    Route::get('retur', 'ReturItemController@index')->name('retur.index');
    Route::delete('retur/{returItem}', 'ReturItemController@destroy')->name('retur.destroy');
    Route::get('retur/{returItem}', 'ReturItemController@show')->name('retur.show');
    Route::post('retur/create', 'ReturItemController@store')->name('retur.store');
    Route::match(['PUT','PATCH'],'retur/{returItem}/approve','ReturItemController@update')->name('retur.approve');
});
