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

    public function index(Request $request)
    {
        \Debugbar::disable();
        \DB::connection()->enableQueryLog();

        //for postman since not logged in
        $user = User::where('slug', 'taylorswift13')->first();
        //$user = Auth::user();

        if (request()->wantsJson()) {
            $tweets = $user->getTimeline();
            logger()->debug('--------New Request JSONJSONJSON--------');
            logger()->debug(\DB::getQueryLog());
            return $tweets;
        }

        logger()->debug('--------New Request VIEWVIEWVIEW--------');
        logger()->debug(\DB::getQueryLog());

        return view('home', compact('user', 'tweets'));
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
}
