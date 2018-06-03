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
        // This will handle the errors, redirecting and everything,
        // and return an array with all the validated keys, here only content
        $validated = $request->validate([
            'content' => 'required|max:400',
        ]);
        
        /*
        // This does the same and offers more flexibility (you can pass whatever data you want)
        // but I prefer the $request->validate() one
        $validated = $this->validate($request, [
            'content' => 'required|max:400',
        ]);
        */
        
        // Why not letting laravel deal with the keys
        $tweet = Auth::user()->tweets()->create($validated);
        
        // you could use $tweet->exists too
        if ($tweet->wasRecentlyCreated) {
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
