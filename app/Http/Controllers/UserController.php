<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
}
