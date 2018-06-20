<?php

use Illuminate\Http\Request;
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

Route::middleware(['auth:api'])->group(function () {
    Route::get('/timeline', 'TweetController@getTimelineTweets')->name('api.timeline');
    Route::post('/timeline/store', 'TweetController@store')->name('api.timeline.store');

    Route::post('/{user}/follow', 'UserController@followUser')->name('api.user.follow');
    Route::post('/{user}/unfollow', 'UserController@unFollowUser')->name('api.user.unfollow');
});

Route::get('/{user}', 'TweetController@getUserTweets')->name('api.user.tweets');

Route::post('{user}/getFeaturedUsers/{limit?}', 'UserController@getNotFollowingUsers');

//test function
Route::post('test/{user}/{limit?}', 'UserController@getNotFollowingUsers');
//Route::post('test/{user}', function(){
//    return 'sdfds';
//});
