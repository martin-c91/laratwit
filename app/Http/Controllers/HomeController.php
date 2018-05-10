<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\TweetController as TweetControllerAPI;
use Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('auth');
        $tweet = new TweetControllerAPI();
        $data['tweets'] = $tweet->myTweets();
        $data['user'] = Auth::user();

        return view('home', $data);
    }

    public function tweetsByUser($user_slug){
        $tweet = new TweetControllerAPI();
        $data['tweets'] = $tweet->tweetsByUser($user_slug);
        $data['user'] = User::where('slug', $user_slug)->first();
        $data['is_following'] = UserController::isFollowing($data['user'], Auth::user());

        return view('home', $data);
    }
}
