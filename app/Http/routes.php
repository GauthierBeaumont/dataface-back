<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function() {
    Route::get('test', function() {
        return response()->json(['name' => 'Dataface yo']);
    });

//    Route::get('presentation/{id}', ['as' => 'presentation', 'uses' => 'SocietysController@show']
//    Route::get('presentation/{id}', ['as' => 'updateSociety', 'uses' => 'SocietysController@show']);

    Route::resource('society', 'SocietiesController', ['only' => ['show', 'update', 'store', 'edit']]);

    Route::resource('support', 'SupportsController');
});
