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
Route::get('/getRole','RolesController@getRole');
Route::post('/addRole','RolesController@addRole');
Route::post('/editRole','RolesController@editRole');
Route::post('/deleteRole','RolesController@deleteRole');
Route::post('/assignPermissions','RolesController@assignPermissions');

Route::post('/login','AuthController@login');
Route::get('/logout','AuthController@logout');
Route::post('/registerUser','AuthController@registerUser');
Route::post('/registerOwner','AuthController@registerOwner');


Route::get('/getNewMechanics','MechanicsController@getNewMechanics');
Route::get('/getMechanicDetails/{id}','MechanicsController@getMechanicDetails');
Route::get('/getOwnerCompany/{id}','MechanicsController@getOwnerCompany');
Route::post('/updateCompany','MechanicsController@updateCompany');
Route::get('/getCompanies','MechanicsController@getCompanies');
Route::get('/getSpecializations','MechanicsController@getSpecializations');

Route::get('/getMechanicComments/{id}','CommentsController@getMechanicComments');
Route::post('/addComment','CommentsController@addComment');
Route::post('/reportComment','CommentsController@reportComment');
Route::post('/reportCompany','CommentsController@reportCompany');

Route::get('/getRepairDetails/{id}','RepairsController@getRepairDetails');
Route::get('/getRepairMessages/{id}','RepairsController@getRepairMessages');
Route::post('/addMessage','RepairsController@addMessage');

Route::get('/getCarsBrandAndModels','CarsController@getCarsBrandAndModels');
Route::get('/getUserCars','CarsController@getUserCars');
Route::post('/saveCar','CarsController@saveCar');
Route::post('/deleteUserCar','CarsController@deleteUserCar');
Route::post('/editUserCar','CarsController@editUserCar');
Route::post('/addNote','CarsController@addNote');
Route::post('/editUserNote','CarsController@editUserNote');
Route::post('/deleteUserNote','CarsController@deleteUserNote');
Route::get('/getUserNotes','CarsController@getUserNotes');

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

