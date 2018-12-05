<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;
use Auth;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

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

    public function findForPassport($slug) {
        return $this->where('slug', $slug)->first();
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

    public function likes()
    {
        return $this->belongsToMany('App\Tweet', 'likes', 'user_id', 'tweet_id')->withTimestamps();
    }

    /**
     * Add follower to current user
     *
     * @param  User $user
     * @return Model
     */
    public function follow(User $user)
    {
        $user->followers()->syncWithoutDetaching($this->id);

        //event(new UserFollowedAnotherUser($user));

        return $user;
    }

    public function unfollow(User $user)
    {
        $user->followers()->detach($this->id);

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
        return $this->followings()->whereIn('user_id', $users)->exists();
    }

    public function getIsFollowingAttribute()
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
        $avatar_file_path = "{$this->avatar_folder}/$this->avatar_file_name";

        return $avatar_file_path;
    }

    public function getAvatarUrlAttribute()
    {
        return Storage::url($this->avatar_folder.'/'.$this->avatar_file_name);
    }

    public function get_and_store_avatar($avatar_origin_url)
    {
        return Storage::put($this->avatar_folder.'/'.$this->avatar_file_name, file_get_contents($avatar_origin_url), 'public');
    }

    /**
     * @param \App\User $user
     * @return $tweets collection
     */
    public function getTimeline()
    {
        // This will do a 'Select id' instead of an uneeded 'Select *'
        // and return a collection of ids, instead of a collection of
        // models then map it in php, when the following relation isn't loaded yet
        $ids = $this->relationLoaded('following')?
             $this->followings->pluck('id'):
             $this->followings()->pluck('id');

        return Tweet::with('user')
            ->with('likedByAuth')
            // whereIn allows collections
            ->whereIn('user_id', $ids->push($this->id))
            ->latest()
            ->paginate();
    }
}
