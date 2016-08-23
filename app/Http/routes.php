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

use \App\Http\Middleware\Ip;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api', 'middleware' => ['cors', 'ip']], function() {
    Route::get('test', function() {
        return response()->json(['name' => 'Dataface yo']);
    });

    Route::get('subscription-info/{user}', 'SubscriptionController@info');
});
