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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'TweetController@store')->name('new-tweet');

//
//tweet by individual user
Route::get('/user/{user_slug}', 'HomeController@tweets_by_user');


Route::get('/test1', 'TweetController@my_tweets')->name('myTweets');

Route::get('test', function(){

});