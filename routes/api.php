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
Route::post('register', 'Api\UserController@register')->name('register');
Route::post('login', 'Api\UserController@authenticate')->name('login');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'Api\UserController@getAuthenticatedUser')->name('user');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
