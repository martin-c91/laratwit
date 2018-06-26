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

Auth::routes();
Route::get('/timeline', 'TweetController@index')->name('timeline')->middleware('auth');
Route::get('/{user}', 'TweetController@index')->name('user.profile');

//get user followers, followings
Route::get('/{user}/followers', 'UserController@followers')->name('user.followers');
Route::get('/{user}/followings', 'UserController@followings')->name('user.followings');

//test function
Route::get('test/{user}', function (User $user) {
    return $user->append('isFollowing')->toJson();
    return Auth::user()->toJson();
});
