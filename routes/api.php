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
    return $request->user()->append('isFollowing');
});
Route::get('/test', function(Request $request){
    //return Auth::user()->followings;
    return User::find(6)->append('isFollowing');
})->middleware('auth:api');
Route::middleware(['auth:api'])->group(function () {
    //timeline actions
    Route::get('/timeline', 'TweetController@getTimelineTweets')->name('api.timeline');
    Route::post('/timeline/store', 'TweetController@store')->name('api.timeline.store');
    Route::delete('/tweet/{id}', 'TweetController@destroy');

    //following action
    Route::post('/following/{id}', 'FollowingController@store')->name('api.user.follow');
    Route::delete('/following/{id}', 'FollowingController@destroy')->name('api.user.unfollow');

    //tweet likes action
    Route::post('like/{id}', 'LikeController@store');
    Route::delete('like/{id}', 'LikeController@destroy');
});



//following list actions
Route::get('/{user}', 'TweetController@getUserTweets')->name('api.user.tweets');
Route::get('/{user}/followings', 'UserController@followings')->name('api.user.followings');
Route::get('/{user}/followers', 'UserController@followers')->name('api.user.followers');
Route::post('{user}/getFeaturedUsers/{limit?}', 'UserController@getNotFollowingUsers');


//test function
//Route::post('test/{user}/{limit?}', 'UserController@getNotFollowingUsers');

//Route::post('test/{user}', function(){
//    return 'sdfds';
//});
