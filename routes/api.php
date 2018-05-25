<?php

use Illuminate\Http\Request;
//todo: move this and delete this
use App\User;
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
//get most recent tweets
Route::get('/tweets', 'TweetsController@index');

//individual tweet action
Route::get('/tweet/{id}', 'TweetsController@show');
Route::post('/tweet', 'TweetsController@store');
Route::put('/tweet', 'TweetsController@store');
Route::delete('/tweet/{id}', 'TweetsController@destroy');

//tweet by individual user
//Route::get('/{user_slug}', 'TweetsController@index');

//logged in user tweets
Route::get('/myTweets', 'TweetsController@tweets_dashboard');

//user function
Route::get('/{user_slug}/followers','UserController@followers');
Route::get('/{user_slug}/followings','UserController@followings');

//user following actions
Route::get('/{target_user_slug}/follow', 'UserController@followUser')->name('user.follow');
Route::get('/{target_user_slug}/unfollow', 'UserController@unFollowUser')->name('user.unfollow');
