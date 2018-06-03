<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;
use Auth;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;


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
        'IsFollowedByAuth',
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
     * @param User|int $user
     * @return bool
     */
    public function checkFollowing($user)
    {
        if ($user instanceof self) {
            $user = $user->getKey(); // or $user->id, doesn't matter much.
        }

        return $this->followings()->where('user_id', $user)->exists();
    }

    /**
     * @param mixed $users
     * @return bool
     */
    public function checkFollowingAny($users)
    {
        // we could deal with both collection types the same way tbh, I did it for the example 
        if ($users instanceof EloquentCollection) {
            $users = $users->modelKeys();
        }
        
        if ($users instanceof Collection) {
            $users = $users->pluck('id'); // or $users->map->id using Higher Order Messages
        }
        
        if (! is_array($users)) {
            return $this->checkFollowing($users); // default to single value check
        }

        // whereIn allows collections
        return $this->followings()->whereIn('user_id', $user)->exists();
    }

    public function test(User $user){
        return $user->slug;
    }

    public function getIsFollowedByAuthAttribute()
    {
        if(!Auth::user()) return false;

        if (Auth::user()->checkFollowing($this->id)) {
            return true;
        };
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
        $avatar_folder = 'avatars/';
        $success = Storage::disk('images')->put($avatar_folder.$avatar_file_name, file_get_contents($source), 'public');

        return $success;
    }

    /**
     * @param \App\User $user
     * @return $tweets collection
     */
    public function getTimeline()
    {
        $followingsId = $this
            ->followings
            ->pluck('id')
            ->all();
        array_push($followingsId, $this->id);

        $tweets = Tweet::with('user')
            ->latest()
            ->whereIn('user_id', $followingsId)
            ->paginate();

        return $tweets;
    }

    /**
     * @param $userIds
     * @return $tweets collection
     */
    public function getTweets($userIds)
    {
        $tweets = Tweet::with('user')
            ->whereIn('user_id', $userIds)
            ->latest()
            ->paginate()
            ;
        return $tweets;
    }

}
