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

Route::group(['prefix' => 'api', 'middleware' => ['ip']], function() {

    Route::resource('society', 'SocietiesController', ['only' => ['show', 'update', 'store', 'edit']]);

    Route::resource('questions', 'QuestionsController');

    Route::resource('responses', 'ResponsesController');

    Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

    Route::post('callDelete', ['as' => 'delete_user', 'uses' => 'UsersController@callDelete']);

    Route::get('subscription-info/{user}', 'SubscriptionController@info');

    Route::post('pay', 'PayController@payment');

    Route::get('invoicePdf/{user}','InvoiceController@createInvoicePdf');

    Route::resource('society', 'SocietiesController', ['only' => ['show', 'update', 'store', 'edit']]);

    Route::resource('subscriptions-types', 'SubscriptionTypeController');

    Route::get('generateToken', function() {
        return ['token' => Session::token()];
    });

    Route::post('blocked/{user}', function(App\User $user, Illuminate\Http\Request $request) {
    	$user->changeUserStatusBlockage();
    	return ['status_user_blocked' => $user->isBlocked];
    });

    Route::resource('profile', 'ProfileController');

    Route::put('docker','DockerController@update');
    Route::delete('docker','DockerController@destroy');

    Route::resource('docker','DockerController', ['except' => ['create', 'show', 'edit']]);
    Route::put('dockerTable', 'DockerTableController@update');
    Route::delete('dockerTable', 'DockerTableController@destroy');
    Route::resource('dockerTable','DockerTableController', ['except' => ['create', 'show', 'edit']]);

    // Authentication Routes...
    Route::get('login', 'Auth\AuthJsonController@showLoginForm');
    Route::post('login', 'Auth\AuthJsonController@login');
    Route::get('logout', 'Auth\AuthJsonController@logout');

    // Registration Routes...
    Route::get('register', 'Auth\AuthJsonController@showRegistrationForm');
    Route::post('register', 'Auth\AuthJsonController@register');

});

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

Route::get('home', 'HomeController@index');

Route::get('/', function() {
    return view('welcome');
});
