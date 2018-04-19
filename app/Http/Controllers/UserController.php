<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
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

    public function followUser($target_user_slug, $follower_user_slug = NULL){
        if(!$follower_user_slug) {
            $follower_user_id = Auth::id() ;
        }else{
            $follower_user_id = User::where('slug', $follower_user_slug)->first()->id;
        }

        $target_user = User::where('slug', $target_user_slug)->first();

        if($target_user->followers()->attach($follower_user_id)){
            return "success";
        };
    }

    public function unFollowUser($target_user_slug, $follower_user_slug = NULL){
        if(!$follower_user_slug) {
            $follower_user_id = Auth::id() ;
        }else{
            $follower_user_id = User::where('slug', $follower_user_slug)->first()->id;
        }

        $target_user = User::where('slug', $target_user_slug)->first();

        $target_user->followers()->detach($follower_user_id);
    }

}
