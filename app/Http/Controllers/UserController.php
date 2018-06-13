<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function followers(User $user)
    {
        return $user->followers;
    }

    public function followings(User $user)
    {
        return $user->followings;
    }

    public function followUser(User $user)
    {
        $this->middleware('auth:api');
        return Auth::user()->follow($user);
    }

    public function unFollowUser(User $user)
    {
        $this->middleware('auth:api');
        return Auth::user()->unFollow($user);
    }
}
