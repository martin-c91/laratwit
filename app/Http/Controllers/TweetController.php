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
    //public function __construct()
    //{
    //    $this->middleware(function ($request, $next) {
    //        //\Debugbar::disable();
    //
    //        // Added json or view display
    //        logger()->debug('--------New Request '.($request->wantsJson() ? 'JSON' : 'VIEW').'--------');
    //
    //        \DB::connection()->enableQueryLog();
    //
    //        // This line was bugged
    //        $response = $next($request);
    //
    //        logger()->debug(\DB::getQueryLog());
    //
    //        return $response;
    //    });
    //}

    public function index(User $user = null, Request $request)
    {
        if (request()->wantsJson()) {
            $start = microtime(true);
            if (! $user) {
                $tweets = Auth::user()->getTimeline();
            } else {
                $cache_message = "with cache";
                //$tweets = \Cache::remember('tweets', 10, function () use($user){
                //    return Tweet::with('user')->where('user_id', $user->id)->latest()->paginate();
                //});
                $tweets = Tweet::remember(60)->with('user')->where('user_id', $user->id)->latest()->paginate();
                //$cache_message = "WITHOUT cache";
                //$tweets = Tweet::with('user')->where('user_id', $user->id)->latest()->paginate();
                $duration = (microtime(true)-$start)*1000;
                \Log::info("$cache_message $duration ms.");
            }



            return response()->json($tweets);
        }
        if (! $user) $user = Auth::user();

        return view('home', compact('user'));
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
