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

        $user = User::where('slug', $user_slug)->first();
        $data['tweets'] = $tweet->tweetsByUser($user);
        //return $user;
        $data['user'] = $user;
        $data['is_following'] = UserController::isFollowing($data['user'], Auth::user());

        return view('home', $data);
    }
}
