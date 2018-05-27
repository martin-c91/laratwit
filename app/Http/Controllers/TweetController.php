<?php

namespace App\Http\Controllers;

use App\Tweet;
use App\User;
use Auth;
use App\Http\Resources\Tweet as TweetResource;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;
use Validator;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user=null, Request $request)
    {
        if (!$user) {
            //get followings tweets + our own tweets
            $users_id = Auth::user()->followings->pluck('id')->all();
            array_push($users_id, Auth::id());
            $tweets = $this->tweetsByUsers($users_id, $request);
            $user = Auth::user();
        } else {
            $tweets = $this->tweetsByUsers([$user->id], $request);
            if(Auth::check()){
                $is_following = Auth::User()->checkFollowing($user);
            }
        }

        if (request()->wantsJson()) {
            return $tweets;
        }

        if (!Auth::check()) {
            return $tweets;
        }

        return view('home', compact('user', 'tweets', 'is_following'));
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

        $tweet = new Tweet;
        $tweet->content = $request->input('content');
        $tweet->user_id = Auth::id();
        if ($tweet->save()) {
            return back()->with('message', 'Your tweet was posted.');
        }

        return back()->with('message', 'Error');
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
        return new Tweet($tweet);
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

        if ($tweet->delete()) {
            return "successfully deleted $id";
        }
    }

    /**
     * Get tweets from array of users
     *
     * @param  array $user_id
     * @return array
     */
    public function tweetsByUsers(Array $users_id, Request $request)
    {
        $tweets = Tweet::with('user')->whereIn('user_id', $users_id)->orderBy('created_at', 'desc')->paginate();

        return $tweets;
    }
}
