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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myTweets()
    {
        $followings_user_id = Auth::user()->followings->pluck('id')->all();

        //get followings tweets + our own tweets
        array_push($followings_user_id, Auth::id());

        $tweets = Tweet::with('user')->whereIn('user_id', $followings_user_id)->orderBy('created_at', 'desc')->paginate(5);

        return $tweets;
    }

    public function tweetsByUser(User $user)
    {
        $tweets = $user->tweet;
        return $tweets;
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
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $tweet = new Tweet;

        $tweet->content = $request->input('content');
        $tweet->user_id = Auth::id();
        if($tweet->save()){
            return back()->with('message', 'Your tweet was posted.');
        }
        return back()->with('message', 'Error');
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
