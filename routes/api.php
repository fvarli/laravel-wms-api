<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PalletController;
use App\Http\Controllers\Api\BoxController;
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
    // Create a new pallet (start receiving)
    Route::post('/pallets', 'App\Http\Controllers\Api\PalletController@store');

    // Get details of a specific pallet by ID (including boxes)
    Route::get('/pallets/{pallet}', 'App\Http\Controllers\Api\PalletController@show');

    // Define the pallet as complete and add it to the inventory movement
    Route::post('/pallets/{pallet}/complete', 'App\Http\Controllers\Api\PalletController@complete');

    // Add a new box (associate with pallet_id)
    Route::post('/boxes', 'App\Http\Controllers\Api\BoxController@store');

    // Assign a location to a specific box
    Route::post('/boxes/{box}/assign-location', 'App\Http\Controllers\Api\BoxController@assignLocation');
});

