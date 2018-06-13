<?php

use Illuminate\Http\Request;
//
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

Route::get('/{user}/follow', 'UserController@followUser')->name('user.follow');
Route::get('/{user}/unfollow', 'UserController@unFollowUser')->name('user.unfollow');

Route::get('/test', function() {
    return Auth::user();
});