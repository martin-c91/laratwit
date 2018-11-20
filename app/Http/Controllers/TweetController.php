<?php

namespace App\Http\Controllers;

use App\Tweet;
use App\User;
use Auth;
use App\Http\Resources\Tweet as TweetResource;
use Illuminate\Http\Request;
use Validator;

class TweetController extends Controller
{
    public function index(User $user = null)
    {
        if (! $user) {
            $user = Auth::user();
            $tweetsUrl = route('api.timeline');
        } else {
            $tweetsUrl = route('api.user.tweets', $user->slug);
        }

        $user = $user->append('isFollowing');
        $currentUser = Auth::user();
        return view('home', compact('user','tweetsUrl', 'currentUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|max:400',
        ]);
        $tweet = Auth::user()->tweets()->create($validated);

        if ($tweet->wasRecentlyCreated) {
            return response()->json($tweet->load('user'));
        }
    }

    /**
     * Display the specified resource.
         *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get single tweet by id
        $tweet = Tweet::with('user')->find($id);
        return $tweet;
    }

    public function destroy($id)
    {
        $tweet = Auth::user()->tweets()->findOrFail($id);

        $tweet->delete();
    }

    public static function getTimelineTweets()
    {
        $tweets = Auth::user()->getTimeline();

        if (request()->wantsJson()) {
            return response()->json($tweets);
        }

        return $tweets;
    }

    public static function getUserTweets(User $user)
    {
        //$tweets = Tweet::remember(60)->with('user')->where('user_id', $user->id)->latest()->paginate();
        $tweets = Tweet::with('user')->where('user_id', $user->id)->latest()->paginate();

        if (request()->wantsJson()) {
            return response()->json($tweets);
        }

        return $tweets;
    }
}
