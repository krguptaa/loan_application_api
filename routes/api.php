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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1', 'as' => 'v1.'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
    });

    Route::group(['middleware' => ['jwt.authUser']], function () {
        Route::group(['prefix' => 'auth'], function () {

            Route::post('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');

        });
        // Users
        Route::resource('users', 'UsersController', ['except' => ['create', 'edit']]);

        // Loans
        Route::resource('loans', 'LoansController', ['except' => ['create', 'edit']]);

        // Apply Loan
        Route::post('loans/apply', 'LoansController@applyLoan');

        // Approve Loan
        Route::any('loans/approve','LoansController@approveLoan');

        // Pay a Loan Emi
        Route::post('loans/payloan','LoansController@payLoan');

    });
});
