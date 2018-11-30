<?php

namespace App;

use Watson\Rememberable\Rememberable;
use Auth;

class Tweet extends Model
{
    protected $fillable = [
        'id',
        'content',
        'user_id',
        'json_raw',
    ];

    protected $hidden = [
        'json_raw',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function likes()
    {
        return $this->HasMany('App\Like');
    }

    public function likedByAuth()
    {
        return $this->hasOne('App\Like')->where('user_id', auth()->guard('api')->id());
    }
}
