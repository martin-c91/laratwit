<?php

namespace App\Http\Controllers;
use App\Tweet;
use App\User;
use Auth;
use App\Http\Resources\Tweet as TweetResource;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_tweets()
    {
        //get followers
        $user = User::find(Auth::id());

        $followings_user_id = $user->followings->pluck('id')->all();

        //get all tweets
        array_push($followings_user_id, Auth::id());

        $tweets = Tweet::with('user')->whereIn('user_id', $followings_user_id)->orderBy('created_at', 'desc')->paginate(10);
        //return TweetResource::collection($tweets);
        return $tweets;
    }

    public function tweets_by_user($user_slug)
    {

        $user_id = User::where('slug', $user_slug)->first()->id;
        $tweets = Tweet::with('user')->where('user_id', $user_id)->paginate(10);
        return $tweets;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //if($request->isMethod('put')){
        //    //echo "sdf";
        //    //return $request->input('tweet_id');
        //    $tweet = Tweet::findOrFail($request->input('tweet_id'));
        //}else{
        $tweet = new Tweet;
        //}

        //$tweet->id = $request->input('tweet_id');
        $tweet->content = $request->input('content');
        $tweet->user_id = Auth::id();
        //$tweet->user_id = $request->input('user_id');
        if($tweet->save()){
            return back()->with('status', 'Your tweet was posted.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get single tweet by id
        $tweet = Tweet::with('user')->find($id);
        //return $tweet;
        return new Tweet($tweet);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tweet = Tweet::findOrFail($id);

        if($tweet->delete()){
            return "successfully deleted $id";
        }
    }
}
