<?php

namespace App\Http\Controllers;

use App\Like;
use App\Tweet;
use App\User;
use Illuminate\Http\Request;
use Auth;

class LikeController extends Controller
{
    public function store($id)
    {
        $result = Auth::user()->likes()->syncWithoutDetaching($id);
        if($result['attached']){
            $tweet = Tweet::whereId($id)->increment('likes');
            return $tweet;
        }
    }

    public function destroy($id)
    {
        $result = Auth::user()->likes()->detach($id);
        if($result){
            $tweet = Tweet::whereId($id)->decrement('likes');
            return $tweet;
        }
    }
}
