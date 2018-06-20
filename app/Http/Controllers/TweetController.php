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
    public function index(User $user = null, Request $request)
    {
        if (! $user){
            $user = Auth::user();
            $tweetsUrl = route('api.timeline');
        }else{
            $tweetsUrl = route('api.user.tweets', $user->slug);
        }

        return view('home', compact('user', 'tweetsUrl'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:400',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try{
            $tweet = new Tweet;
            $tweet->content = $request->input('content');
            $tweet->user_id = Auth::id();
            if ($tweet->save()) {
                return response()->json($tweet->load('user'));
            }
        }catch(\Exception $e){
            // do task when error
            echo $e->getMessage();
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
        //return $tweet;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tweet = Tweet::findOrFail($id);
        $tweet->delete;
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
        $tweets = Tweet::remember(60)->with('user')->where('user_id', $user->id)->latest()->paginate();

        if (request()->wantsJson()) {
            return response()->json($tweets);
        }

        return $tweets;
    }
}
