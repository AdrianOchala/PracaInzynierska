<?php

use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => 'checkrole:User,Owner,Admin,Bóg'], function() {

});
Route::group(['middleware'=>'checkrole:Owner'], function (){
    Route::get('/test','TestController@test');

});
Route::get('/getRole','TestController@getRole');
Route::post('/addRole','TestController@addRole');
Route::post('/editRole','TestController@editRole');
Route::post('/deleteRole','TestController@deleteRole');
Route::post('/assignPermissions','TestController@assignPermissions');

Route::post('/login','AuthController@login');
Route::get('/logout','AuthController@logout');
Route::post('/registerUser','AuthController@registerUser');
Route::post('/registerOwner','AuthController@registerOwner');

Route::get('/getSpecializations','TestController@getSpecializations');
Route::get('/getCompanies','TestController@getCompanies');
Route::get('/getNewMechanics','MechanicsController@getNewMechanics');
Route::get('/getMechanicDetails/{id}','MechanicsController@getMechanicDetails');
Route::get('/getOwnerCompany/{id}','MechanicsController@getOwnerCompany');
Route::get('/getMechanicComments/{id}','CommentsController@getMechanicComments');
Route::get('/getRepairDetails/{id}','RepairsController@getRepairDetails');
Route::post('/addComment','CommentsController@addComment');
Route::post('/updateCompany','MechanicsController@updateCompany');

Route::get('/getCarsBrandAndModels','CarsController@getCarsBrandAndModels');
Route::get('/getUserCars','CarsController@getUserCars');
Route::post('/saveCar','CarsController@saveCar');
Route::post('/deleteUserCar','CarsController@deleteUserCar');
Route::post('/editUserCar','CarsController@editUserCar');
Route::post('/addNote','CarsController@addNote');
Route::get('/getUserNotes','CarsController@getUserNotes');
Route::post('/reportComment','CommentsController@reportComment');
Route::post('/addRepair','RepairsController@addRepair');
Route::post('/acceptRepair','RepairsController@acceptRepair');

Route::get('/getUserRepairs','RepairsController@getUserRepairs');
Route::get('/','AuthController@index');
Route::get('/unauthorised','AuthController@unauthorised');
Route::any('{slug}','AuthController@index')->where('slug', '([A-z\d-\/_.]+)?');

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::any('{slug}', function () {
//    return view('welcome');
//});

