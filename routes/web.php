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
})->name('login');

//Auth
Auth::routes();

Route::group(['middleware' => ['auth']], function () {



Route::get('/home', 'HomeController@index')->name('home');

//Reports
Route::get('/reports','ReportController@index')->name('reports');

//Clients
Route::get('/clients','ClientController@index')->name('clients')->middleware('auth');
Route::get('/client/{id}','ClientController@show')->name('client');
Route::post('/client','ClientController@store')->name('createclient');
Route::put('/client/{id}','ClientController@update')->name('updateClient');
Route::patch('/client/photo','ClientController@updatePhoto')->name('updatePhotoClient');
Route::patch('/client','ClientController@destroy')->name('deleteclient');

//Sales
Route::get('/sales','SaleController@index')->name('sales');
Route::get('/sale/{id}','SaleController@show')->name('sale');
Route::put('/sale','SaleController@update')->name('updatesale');
Route::post('/sale','SaleController@store')->name('salevehicleclient');

//Investors
Route::get('/investors','InvestorController@index')->name('investors');
Route::post('/investor','InvestorController@store')->name('createinvestor');
Route::get('/investor/{id}','InvestorController@show')->name('investor');
Route::put('/investor','InvestorController@update')->name('updateInvestor');
Route::patch('/investor/delete','InvestorController@destroy')->name('deleteinvestor');

//Vehicles
Route::get('/vehicles','VehicleController@index')->name('vehicles');
Route::get('/vehicle/{id}','VehicleController@show')->name('vehicle');
Route::post('/vehicle','VehicleController@store')->name('createVehicle');
Route::patch('/vehicle','VehicleController@destroy')->name('deleteVehicle');
Route::patch('/vehicle/photo','VehicleController@updatePhoto')->name('updatePhotovehicle');
Route::put('/vehicle','VehicleController@update')->name('updateVehicle');

//BranchOffices
Route::get('/branchoffices','BranchofficeController@index')->name('branchOffices');
Route::get('/branchoffice/{id}','BranchofficeController@show')->name('branchoffice');
Route::put('/branchoffice/{id}','BranchofficeController@update')->name('updateBranchoffice');
Route::post('/branchoffices','BranchofficeController@store')->name('createBranch');
Route::patch('/branchoffice','BranchofficeController@destroy')->name('deleteBranchoffice');

//Employess
Route::get('/employees','EmployeeController@index')->name('employees');
Route::post('/employee','EmployeeController@store')->name('createEmployee');
Route::get('/employee/{id}','EmployeeController@show')->name('employee');
Route::put('/employee','EmployeeController@update')->name('updateEmployee');
Route::patch('/employee','EmployeeController@updatePhoto')->name('updatePhoto');
Route::patch('/employee/delete','EmployeeController@destroy')->name('deleteEmployee');
Route::patch('/employee/asignBranch','EmployeeController@asign')->name('asignBrEmployee');

//Validates
Route::post('/validate/email','ValidateFormsController@ValidateEmail')->name('ValidateEmail');

//Payments
Route::get('/payments','PaymentController@index')->name('payments');
Route::post('/payment','PaymentController@store')->name('createPayment');
Route::get('/payment/{id}','PaymentController@show')->name('payment');
Route::put('/payment','PaymentController@update')->name('updatepPayment');
Route::patch('/payment/delete','PaymentController@destroy')->name('deletePayment');

Route::get('/loans','LoansController@index')->name('loans');
Route::get('/expenses','BranchOfficeController@index')->name('expenses');

});
