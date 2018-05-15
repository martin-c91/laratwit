<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public static function isFollowing(User $target_user, User $user)
    {
        $isFollowing = $target_user->followers()->where('follower_id', $user->id)->exists();
        return $isFollowing;
    }

    public function followers($user_slug)
    {
        $user = User::where('slug', $user_slug)->first();

        $followers = $user->followers->all();

        return $followers;
    }

    public function followings($user_slug)
    {
        $user = User::where('slug', $user_slug)->first();

        $followings = $user->followings->all();

        return $followings;
    }

    public function followUser($target_user_slug, $follower_user_slug = null)
    {
        if (! $follower_user_slug) {
            $follower_user_id = Auth::id();
        } else {
            $follower_user_id = User::where('slug', $follower_user_slug)->first()->id;
        }

        $target_user = User::where('slug', $target_user_slug)->first();

        try {
            $target_user->followers()->attach($follower_user_id);

            //return $target_user;
            return back()->with('message', 'You are currently following @'.$target_user->slug);
        } catch (\Illuminate\Database\QueryException $ex) {
            if ($ex->getCode() == 23000) {
                return back()->with('message', 'Already Followed '.$target_user->slug);
            };
        }
        //return back()->with('message', 'Error');
    }

    public function unFollowUser($target_user_slug, $follower_user_slug = null)
    {
        if (! $follower_user_slug) {
            $follower_user_id = Auth::id();
        } else {
            $follower_user_id = User::where('slug', $follower_user_slug)->first()->id;
        }

        $target_user = User::where('slug', $target_user_slug)->first();

        if ($target_user->followers()->detach($follower_user_id)) {
            return back()->with('message', 'You are no longer following @'. $target_user->slug);
        };

        return back()->with('message', 'Error');
    }
}
