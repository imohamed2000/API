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
    Route::get('schools/trashed','SchoolsController@trashed');
    Route::post('schools/restore/{id}','SchoolsController@restore');
    Route::get('school/current/{id}','SchoolsController@getCurrent');
    Route::post('school/{school}/current/{id}','SchoolsController@postCurrent');
    Route::resource('school.users', 'UserController');
    Route::get('school/{School}/users/trashed','UserController@trashed');
    Route::post('school/{school}/users/{user}/restore','UserController@restore');
    // Mapping Section User Year
    Route::get('school/{school}/user/{id}/section','UserController@getSection');
    Route::post('school/{school}/user/{id}/section','UserController@storeSection');

    // Get Users of specific section
    Route::get('school/{school}/section/{id}/users','UserController@getUsersSection');

    Route::resource('school.classes', 'ClassesController');
    Route::resource('school.sections', 'SectionsController');
    Route::resource('school.roles', 'RolesController');
    Route::apiResource('school.grades', 'GradeController');
    Route::apiResource('school.years', 'YearController');
    Route::post('school/{school}/grades/sort', 'GradeController@sort');
    Route::get('school/{School}/grades/trashed','GradeController@trashed');
    Route::post('school/{school}/grades/{grade}/restore','GradeController@restore');
    Route::resource('permissions', 'PermissionsController');
    //Route::resource('roles.permissions','RolesPermissionsController');

    // Relation between Roles and permission
    Route::post('roles/{role}/permissions','RolesPermissionsController@store');
    Route::put('roles/{role}/permissions','RolesPermissionsController@update');
    Route::get('roles/{role}/permissions','RolesPermissionsController@show');
    Route::get('roles/permissions','RolesPermissionsController@index');

});

