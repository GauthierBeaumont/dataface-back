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

Route::group(['prefix' => 'api', 'middleware' => ['cors', 'ip']], function() {
    Route::get('test', function() {
        return response()->json(['name' => 'Dataface yo']);
    });

    Route::get('subscription-info/{user}', 'SubscriptionController@info');

    Route::post('pay', 'PayController@payment');
});


// Authentication Routes...
Route::get('login', 'Auth\AuthJsonController@showLoginForm');
Route::post('login', 'Auth\AuthJsonController@login');
Route::get('logout', 'Auth\AuthJsonController@logout');

// Registration Routes...
Route::get('register', 'Auth\AuthJsonController@showRegistrationForm');
Route::post('register', 'Auth\AuthJsonController@register');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

Route::get('home', 'HomeController@index');

Route::get('/', function() {
  return view('welcome');
});
