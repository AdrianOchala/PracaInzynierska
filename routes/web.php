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
    Route::get('/getRole','TestController@getRole');



});
Route::group(['middleware'=>'checkrole:Owner'], function (){
    Route::get('/test','TestController@test');

    Route::post('/addRole','TestController@addRole');
});

    Route::post('/editRole','TestController@editRole');
    Route::post('/deleteRole','TestController@deleteRole');
    Route::post('/assignPermissions','TestController@assignPermissions');

Route::post('/login','AuthController@login');
Route::get('/logout','AuthController@logout');
Route::post('/registerUser','AuthController@registerUser');
Route::post('/registerOwner','AuthController@registerOwner');
Route::get('/getSpecializations','TestController@getSpecializations');
Route::get('/getCompanies','TestController@getCompanies');
Route::get('/unauthorised','AuthController@unauthorised');

Route::get('/','AuthController@index');
Route::any('{slug}','AuthController@index');

//Route::get('/', function () {
//    return view('welcome');
//});
//
//Route::any('{slug}', function () {
//    return view('welcome');
//});

