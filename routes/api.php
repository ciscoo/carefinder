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

// Unprotected routes
Route::group(['middleware' => 'api'], function () {
    Route::get('/key', 'KeyController@get');
    Route::post('/key/{key}', 'KeyController@save');
    Route::post('/key/{key}/{level}', 'KeyController@createLevel');    
    
    Route::get('/hospitals', 'HospitalController@index');
    Route::get('/hospitals/id/{id}', 'HospitalController@show');
    Route::get('/hospitals/city/{name}', 'HospitalController@showByCity');
    Route::get('/hospitals/state/{name}', 'HospitalController@showByState');
    Route::get('/hospitals/county/{name}', 'HospitalController@showByCounty');
    Route::get('/hospitals/statecity/{state}/{city}', 'HospitalController@showByStateCity');
    Route::get('/hospitals/name/{name}', 'HospitalController@showByName');
    Route::get('/hospitals/type/{type}', 'HospitalController@showbyType');
    Route::get('/hospitals/ownership/{owner}', 'HospitalController@showbyOwner');
    Route::get('/hospitals/emergency/{emergency}', 'HospitalController@showbyEmergency');
    Route::get('/hospitals/latlon/{latitude}/{longitude}/{distance}', 'HospitalController@showbyDistance');
    
});

// Protected routes
Route::group(['middleware' => ['api', 'level']], function () {
    Route::get('/keys', 'KeyController@index');
    Route::delete('/key/{key}', 'KeyController@delete');
    Route::get('/key/{key}', 'KeyController@index');

    Route::post('/hospitals', 'HospitalController@createHospital');
    Route::put('/hospitals/id/{id}', 'HospitalController@updateOrCreate');
    Route::delete('/hospitals', 'HospitalController@deleteAllHospitals');    
    Route::delete('/hospitals/id/{id}', 'HospitalController@deleteById');
    Route::delete('/hospitals/city/{name}', 'HospitalController@deleteByCity');
    Route::delete('/hospitals/state/{name}', 'HospitalController@deleteByState');
    Route::delete('/hospitals/county/{name}', 'HospitalController@deleteByCounty');
    Route::delete('/hospitals/statecity/{state}/{city}', 'HospitalController@deleteByStateCity');
    Route::delete('/hospitals/name/{name}', 'HospitalController@deleteByName');
    Route::delete('/hospitals/type/{type}', 'HospitalController@deleteByType');
    Route::delete('/hospitals/ownership/{owner}', 'HospitalController@deletebyOwner');
    Route::delete('/hospitals/emergency/{emergency}', 'HospitalController@deletebyEmergency');
    Route::delete('/hospitals/latlon/{latitude}/{longitude}/{distance}', 'HospitalController@deletebyDistance');
});
