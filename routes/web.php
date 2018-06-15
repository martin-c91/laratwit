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
        return redirect('dashboard');
    }

    return view('welcome');
});

Auth::routes();
Route::get('/dashboard', 'TweetController@index')->name('timeline')->middleware('auth');
Route::post('/dashboard/tweet', 'TweetController@store')->name('tweet.post');

Route::get('/{user}', 'TweetController@index')->name('user.profile');

//get user followers, followings
Route::get('/{user}/followers', 'UserController@followers')->name('user.followers');
Route::get('/{user}/followings', 'UserController@followings')->name('user.followings');

//test function
Route::get('test/{user}', function (User $user) {
    return $user->append('AuthIsFollowing')->toJson();
    return Auth::user()->toJson();
});
