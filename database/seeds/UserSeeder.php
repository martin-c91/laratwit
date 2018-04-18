<?php

use Illuminate\Database\Seeder;
Use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $twitter_user_name;

    public function __construct($twitter_user_name)
    {
        $this->twitter_user_name = $twitter_user_name;
    }

    public function run()
    {
        $seed_user = Twitter::getUsers(['screen_name' => $this->twitter_user_name, 'format' => 'json']);
        $seed_user = json_decode($seed_user);

        $new_user = User::create([
            'name' => $seed_user->name,
            'slug' => $seed_user->screen_name,
            'description' => $seed_user->description,
            'avatar' => $seed_user->profile_image_url,

            'password' => Hash::make('test')
        ])->get();

        if(isset($new_user)) return $new_user;
    }

}
