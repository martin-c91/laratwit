<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\User;
use App\Tweet;
Use App\Http\Controllers\UserController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('timeline');
    }

    return redirect('login');
});

//test function
Route::get('test/{userid}', function($userId){
    $tweets = Tweet::with('user')
        ->with('likes')
        // whereIn allows collections
        ->where('user_id', $userId)
        ->latest()
->get();
    //$tweets = $tweets->append('liked_by_auth');
    return $tweets;
});

Route::get('test1/{tweet_id}', 'LikeController@destroy');

Auth::routes();
Route::get('/timeline', 'TweetController@index')->name('timeline')->middleware('auth');
Route::get('/{user}', 'TweetController@index')->name('user.profile');

//get user followers, followings
Route::get('/{user}/followers', 'UserController@followers')->name('user.followers');
Route::get('/{user}/followings', 'UserController@followings')->name('user.followings');

Route::get('/healthcheck', function(){
    return response('System up', 200)
        ->header('Content-Type', 'text/plain');
});
