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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
	//Auth routes
	Route::post('login', 'Auth\LoginController@login');
	Route::post('logout', 'Auth\LoginController@logout');
	//TODO implement password reset flow.
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::resource('schools','SchoolsController');
    Route::resource('school.users', 'UserController');
    Route::resource('school.classes', 'ClassesController');
    Route::resource('school.classes.section', 'ClassesController');
});

