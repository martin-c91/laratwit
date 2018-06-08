<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $avatar_folder = 'avatars';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'slug',
        'json_raw',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'json_raw',
        'avatar_origin',
        'updated_at',
        'created_at',
    ];

    protected $appends = [
        //'IsFollowedByAuth',
        'avatar_url',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tweets()
    {
        return $this->hasMany('App\Tweet');
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'followers', 'user_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'user_id');
    }

    /**
     * Add follower to current user
     *
     * @param  User $user
     * @return Model
     */
    public function follow(User $user)
    {
        if (! $this->checkFollowing($user->id)) {
            $user->followers()->attach($this->id);
        }

        //event(new UserFollowedAnotherUser($user));

        return $user;
    }

    public function unFollow(User $user)
    {
        if ($this->checkFollowing($user->id)) {
            $user->followers()->detach($this->id);
        }

        //event(new UserUnFollowedAnotherUser($user));

        return $user;
    }

    /**
     * @param $userId int
     * @return bool
     */
    public function checkFollowing($userId)
    {
        if ($this->followings()->where('user_id', $userId)->first()) {
            return true;
        }

        return false;
    }

    public function getAuthIsFollowingAttribute()
    {
        if(!Auth::user()) return false;

        if (Auth::user()->checkFollowing($this->id)) {
            return true;
        };

        return false;
    }

    /**
     * Get the path to the user's avatar.
     *
     * @param  string $slug
     * @return string
     */
    public function getAvatarAttribute()
    {
        $avatar_file_name = ($this->slug.'.png');
        if (Storage::disk('images')->exists($this->avatar_folder.'/'.$avatar_file_name)) {
            return ($this->avatar_folder.'/'.$avatar_file_name);
        }

        return ($this->avatar_folder.'/'.'default.png');
    }

    public function getAvatarUrlAttribute()
    {
        return Storage::disk('images')->url($this->avatar);
    }

    public function get_and_store_avatar()
    {
        $storage = Storage::class;
        //return $storage;
        $source = $this->avatar_origin;
        $avatar_file_name = $this->slug.'.png';
        $success = Storage::disk('images')->put($this->avatar_folder.'/'.$avatar_file_name, file_get_contents($source), 'public');

        return $success;
    }

    /**
     * @param \App\User $user
     * @return $tweets collection
     */
    public function getTimeline()
    {
        clock()->startEvent('getTimeline', "getTimeline method query");

        $followingsId = $this->followings->pluck('id')->all();
        array_push($followingsId, $this->id);

        $tweets = Tweet::remember(60)->with('user')->whereIn('user_id', $followingsId)->latest()->paginate();
        clock()->endEvent('getTimeline');
        return $tweets;
    }
}