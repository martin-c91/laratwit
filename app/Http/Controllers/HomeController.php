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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tweet = new TweetControllerAPI();
        $data['tweets'] = $tweet->my_tweets();
        $data['user'] = Auth::user();

        return view('home', $data);
    }

    public function tweets_by_user($user_slug){
        $tweet = new TweetControllerAPI();
        $data['tweets'] = $tweet->tweets_by_user($user_slug);
        $data['user'] = User::where('slug', $user_slug);

        return view('home', $data);
    }
}
