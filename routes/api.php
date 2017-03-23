<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group([
    'middleware' => 'auth:api'
], function () {
	Route::resource('user.account', 'AccountController');
	Route::resource('account', 'AccountController',['only' => [
		'show', 'index', 'update', 'destroy'
	]]);
	Route::resource('account.transaction', 'TransactionController');
	Route::resource('transaction', 'TransactionController', ['only' => [
		'show', 'index', 'update', 'destroy'
	]]);
	Route::resource('user.budget', 'BudgetController');
	Route::resource('budget', 'BudgetController', ['only' => [
		'show', 'index', 'update', 'destroy'
	]]);
});