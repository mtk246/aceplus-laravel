<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
Route::get('/company', 'CompanyController@index')->name('company');
Auth::routes();
Route::get('/employee', 'EmployeeController@index')->name('employee');
Auth::routes();


Route::post('/companyv1', 'CompanyController@postCompany')->name('companyv1');
Route::post('/companyedit', 'CompanyController@putCompany')->name('companyedit');
Route::post('/companydelete', 'CompanyController@deleteCompany')->name('companydelete');

Route::post('/employeev1', 'EmployeeController@postEmployee')->name('employeev1');
Route::post('/employeeedit', 'EmployeeController@putEmployee')->name('employeeedit');
Route::post('/employeedelete', 'EmployeeController@deleteEmployee')->name('employeedelete');



///// API Routes //////

//**** Company API *****/
Route::get('/api/company', 'CompanyApiController@getCompany');
Route::post('/api/company', 'CompanyApiController@postCompany');
Route::put('/api/company', 'CompanyApiController@putCompany');
Route::delete('/api/company', 'CompanyApiController@deleteCompany');


//**** Employee API *****/
Route::get('/api/employee', 'EmployeeApiController@getEmployee');
Route::post('/api/employee', 'EmployeeApiController@postEmployee');
Route::put('/api/employee', 'EmployeeApiController@putEmployee');
Route::delete('/api/employee', 'EmployeeApiController@deleteEmployee');
