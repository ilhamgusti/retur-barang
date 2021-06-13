<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\TransaksiController;
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



Route::group([
    'middleware'    => ['auth:sanctum'],
    'namespace'  => 'API',
    // 'prefix'     => 'reports',
    // 'as' => 'api.'
],function () {
    Route::apiResource('customers', 'CustomerController', ['except' => 'update']);
    // Route::match(['PUT', 'PATCH'], 'panti', [PantiController::class, 'update'])->name('panti.update');
    Route::apiResource('transaksi', 'TransaksiController');
    Route::get('retur/{id}', 'ReturItemController@show')->name('retur.show');
    Route::post('retur/create', 'ReturItemController@store')->name('retur.store');
    Route::match(['PUT','PATCH'],'retur/{id}/approve','ReturItemController@update')->name('retur.approve');
});
