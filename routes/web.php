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

Route::get('/', function () {
    return view('welcome');
});

//Auth
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Reports
Route::get('/reports','ReportController@index')->name('reports');

//Clients
Route::get('/clients','ClientController@index')->name('clients');

//Investors
Route::get('/investors','InvestorController@index')->name('investors');
Route::post('/investor','InvestorController@store')->name('createinvestor');
Route::get('/investor/{id}','InvestorController@show')->name('investor');
Route::put('/investor/{id}','InvestorController@update')->name('updateinvestor');

//Vehicles
Route::get('/vehicles','VehicleController@index')->name('vehicles');
Route::get('/vehicle/{id}','VehicleController@show')->name('vehicle');
Route::post('/vehicle','VehicleController@store')->name('createVehicle');
Route::patch('/vehicle','VehicleController@destroy')->name('deleteVehicle');
Route::put('/vehicle','VehicleController@update')->name('updateVehicle');

//BranchOffices
Route::get('/branchoffices','BranchOfficeController@index')->name('branchOffices');
Route::get('/branchoffice/{id}','BranchofficeController@show')->name('branchoffice');
Route::post('/branchoffices','BranchOfficeController@store')->name('createBranch');

//Employess
Route::get('/employees','EmployeeController@index')->name('employees');
Route::post('/employee','EmployeeController@store')->name('createEmployee');
Route::get('/employee/{id}','EmployeeController@show')->name('employee');
Route::put('/employee','EmployeeController@update')->name('updateEmployee');
Route::patch('/employee','EmployeeController@updatePhoto')->name('updatePhoto');
Route::patch('/employee/delete','EmployeeController@destroy')->name('deleteEmployee');


Route::get('/loans','LoansController@index')->name('loans');
Route::get('/expenses','BranchOfficeController@index')->name('expenses');