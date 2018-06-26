<?php

namespace App\Http\Controllers;

use App\Following;
use App\User;
use Illuminate\Http\Request;
use Auth;

class FollowingController extends Controller
{
    public function store($id)
    {
        Auth::user()->followings()->syncWithoutDetaching($id);
        return Auth::user()->followings;
    }

    public function destroy($id)
    {
        Auth::user()->followings()->detach($id);
        return Auth::user()->followings;
    }
}
