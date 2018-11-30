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
        $avatar_file_path = "{$this->avatar_folder}/{$this->slug}.png";

        return Storage::disk('images')->exists($avatar_file_path)?
            $avatar_file_path:
            "{$this->avatar_folder}/default.png";
    }

    public function getAvatarUrlAttribute()
    {
        return Storage::disk('images')->url($this->avatar);
    }

    public function get_and_store_avatar()
    {
        return Storage::disk('images')->put("avatars/{$this->slug}.png", file_get_contents($this->avatar_origin), 'public');
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
            // whereIn allows collections
            ->whereIn('user_id', $ids->push($this->id))
            ->latest()
            ->paginate();
    }
}
