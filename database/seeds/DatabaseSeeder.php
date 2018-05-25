<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Tweet;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $seed_users = [
        'katyperry',
        'justinbieber',
        'BarackObama',
        "rihanna",
        "taylorswift13",
        "ladygaga",
        "TheEllenShow",
        "Cristiano",
        "jtimberlake",
        "Twitter",
        "KimKardashian",
        "britneyspears",
        "ArianaGrande",
        "ddlovato",
        "selenagomez",
        "cnnbrk",
        "jimmyfallon",

    ];

    public function run()
    {
        foreach($this->seed_users as $seed_user)
        {
            if($this->seed_user_info($seed_user))
            {
                $this->seed_user_tweets($seed_user, 10);
            }
        }
    }

    protected function seed_user_info($twitter_username)
    {
        $seed_user_json = Twitter::getUsers(['screen_name' => $twitter_username, 'format' => 'json']);
        $seed_user = json_decode($seed_user_json);

        $new_user = new User;
        $data = [
            'name' => $seed_user->name,
            'slug' => $seed_user->screen_name,
            'email' => $faker = Faker\Factory::create()->email,
            'description' => $seed_user->description,
            'json_raw' => $seed_user_json,
            'avatar' => $seed_user->profile_image_url,
            'password' => Hash::make('test')
        ];

        $success = $new_user->updateOrCreate(['slug' => $twitter_username], $data);
        return $success->slug;
    }

    protected function seed_user_tweets($twitter_username, $tweets_count=30)
    {
        $user = User::where('slug', $twitter_username)->firstOrFail();

        $tweets = Twitter::getUserTimeline(['screen_name' => $user->slug, 'count' => $tweets_count, 'format' => 'json']);
        $tweets = json_decode($tweets);

        foreach($tweets as $tweet){
            $data = [
                'id' => $tweet->id,
                'json_raw' => json_encode($tweet),
                'content' => $tweet->text,
                'user_id' => $user->id,
                'created_at' => strtotime($tweet->created_at)
            ];

            Tweet::updateOrCreate(['id' => $tweet->id], $data);
        }
    }
}