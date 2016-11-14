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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/hospitals', 'HospitalController@index');
    Route::post('/hospitals', 'HospitalController@createHospital');
    Route::delete('/hospitals', 'HospitalController@deleteAllHospitals');

    Route::get('/hospitals/id/{id}', 'HospitalController@show');
    Route::put('/hospitals/id/{id}', 'HospitalController@updateOrCreate');
    Route::delete('/hospitals/id/{id}', 'HospitalController@deleteById');

    Route::get('/hospitals/city/{name}', 'HospitalController@showByCity');
    Route::delete('/hospitals/city/{name}', 'HospitalController@deleteByCity');

    Route::get('/hospitals/county/{name}', 'HospitalController@showByCounty');
    Route::delete('/hospitals/county/{name}', 'HospitalController@deleteByCounty');
});
