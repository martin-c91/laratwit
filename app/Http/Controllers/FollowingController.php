<?php

namespace App\Http\Controllers;

use App\Following;
use App\User;
use Illuminate\Http\Request;
use Auth;

class FollowingController extends Controller
{
    public function __construct()
    {
        $this->user = User::find(request('user_id'));
    }

    public function store()
    {
        Auth::user()->followings()->syncWithoutDetaching($this->user->id);
        return Auth::user()->followings;
    }

    public function destroy($id)
    {
        Auth::user()->followings()->detach($id);
        return Auth::user()->followings;
    }
}
