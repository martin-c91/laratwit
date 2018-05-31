<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

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
    public function follow($user)
    {
        if (! $this->checkFollowing($user)) {
            $user->followers()->attach($this->id);
        }

        //event(new UserFollowedAnotherUser($user));

        return $user;
    }

    /**
     * Add follower to current user
     *
     * @param  User $user
     * @return Model
     */
    public function unFollow($user)
    {
        if ($this->checkFollowing($user)) {
            $user->followers()->detach($this->id);
        }

        //event(new UserUnFollowedAnotherUser($user));

        return $user;
    }

    public function checkFollowing(User $user)
    {
        if ($this->followings()->where('user_id', $user->id)->first()) {
            return true;
        }

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
        $avatar = ('images/avatars/'.$this->slug.'.png');
        if (\Storage::exists($avatar)){
            return ('storage/'.$avatar);
        }
        return ('storage/images/avatars/default.png');
    }

    public function get_and_store_avatar()
    {
        $storage = Storage::class;
        //return $storage;
        $source = $this->avatar_origin;
        $avatar_path = 'images/avatars/'.$this->slug.'.png';
        $success = storage::put($avatar_path, file_get_contents($source), 'public');

        return $success;
    }
}
