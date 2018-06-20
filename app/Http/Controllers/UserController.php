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
        return Auth::user()->follow($user);
    }

    public function unFollowUser(User $user)
    {
        return Auth::user()->unFollow($user);
    }

    public function getNotFollowingUsers(User $user = null, $limit = 20)
    {
        if (! $user) {
            $user = Auth::user();
        }
        $followingsIds = $user->followings()->pluck('id');

        if(request()->input(['exceptUsers'])) $followingsIds = $followingsIds->concat(request()->input(['exceptUsers']));

        return User::whereNotIn('id', $followingsIds)->inRandomOrder()->limit($limit)->get();
    }
}
