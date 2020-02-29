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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/vehicles', 'VehicleController@getVehicles');
Route::middleware('api')->get('/branchoffices', 'BranchofficeController@getBranchs');
Route::middleware('api')->get('/clients', 'ClientController@getClients');
Route::middleware('api')->get('/investors', 'InvestorController@getInvestors');
Route::middleware('api')->get('/salesvehicles', 'VehicleController@getsalesVehicles');
