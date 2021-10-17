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
Route::group(['middleware' => 'checkrole:User,Owner,Admin'], function() {

});
Route::group(['middleware'=>'checkrole:Owner,Admin'], function (){
    Route::get('/test','AdminController@test');

});
Route::group(['middleware'=>'checkrole:Admin'],function(){
   Route::get('/getUsers','AdminController@getUsers');
   Route::get('/getReports','AdminController@getReports');
   Route::post('/deleteUser','AdminController@deleteUser');
   Route::post('/deactivateUser','AdminController@deactivateUser');
   Route::post('/getSingleComment','AdminController@getSingleComment');
   Route::post('/deleteComment','AdminController@deleteComment');
   Route::post('/deleteReport','AdminController@deleteReport');
});

Route::get('/getUserMessages','MessagesController@getUserMessages');
Route::post('/updateMessageView','MessagesController@updateMessageView');
Route::post('/deleteUserMessage','MessagesController@deleteUserMessage');
Route::post('/archiveUserMessage','MessagesController@archiveUserMessage');
Route::post('/sendUserMessage','MessagesController@sendUserMessage');
Route::post('/restoreUserMessage','MessagesController@restoreUserMessage');

Route::get('/getRole','RolesController@getRole');
Route::post('/addRole','RolesController@addRole');
Route::post('/editRole','RolesController@editRole');
Route::post('/deleteRole','RolesController@deleteRole');
Route::post('/assignPermissions','RolesController@assignPermissions');

Route::post('/login','AuthController@login');
Route::get('/logout','AuthController@logout');
Route::get('/deleteAccount','AuthController@deleteAccount');
Route::post('/registerUser','AuthController@registerUser');
Route::post('/registerOwner','AuthController@registerOwner');
Route::post('/editPersonalUserData','AuthController@editPersonalUserData');
Route::post('/changeUserPassword','AuthController@changeUserPassword');
Route::post('/checkActivity','AuthController@checkActivity');
Route::post('/activateUser','AuthController@activateUser');


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
Route::get('/bestCompanies','CommentsController@bestCompanies');
Route::get('/getLastComments','CommentsController@getLastComments');

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
Route::post('/rejectRepair','RepairsController@rejectRepair');
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

