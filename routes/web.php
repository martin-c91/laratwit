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
    if(Auth::check()) return redirect('feed');
    return view('welcome');
});

Auth::routes();
Route::get('/feed', 'TweetController@index')->name('feed');

Route::get('/{user}', 'TweetController@index');
Route::post('/{user}/tweet', 'TweetController@store')->name('tweet.post');

Route::post('/{user}/follow', 'UserController@followUser')->name('user.follow');
Route::post('/{user}/unfollow', 'UserController@unFollowUser')->name('user.unfollow');

//get user followers, followings
Route::get('/{user}/followers', 'UserController@followers')->name('user.followers');
Route::get('/{user}/followings', 'UserController@followings')->name('user.followings');

//test function
//Route::get('test/{user}', 'TweetController@test');
