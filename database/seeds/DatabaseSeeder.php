<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Tweet;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $seed_users_origin = [
        'katyperry',
        'justinbieber',
        'BarackObama',
        'rihanna',
        'taylorswift13',
        'ladygaga',
        'TheEllenShow',
        'Cristiano',
        'YouTube',
        'jtimberlake',
        'Twitter',
        'KimKardashian',
        'britneyspears',
        'ArianaGrande',
        'ddlovato',
        'selenagomez',
        'cnnbrk',
        'realDonaldTrump',
        'shakira',
        'jimmyfallon',
        'BillGates',
        'JLo',
        'BrunoMars',
        'narendramodi',
        'Oprah',
        'nytimes',
        'KingJames',
        'MileyCyrus',
        'CNN',
        'NiallOfficial',
        'neymarjr',
        'instagram',
        'BBCBreaking',
        'Drake',
        'SportsCenter',
        'iamsrk',
        'KevinHart4real',
        'SrBachchan',
        'LilTunechi',
        'espn',
        'wizkhalifa',
        'Louis_Tomlinson',
        'BeingSalmanKhan',
        'Pink',
        'LiamPayne',
        'Harry_Styles',
        'onedirection',
        'aliciakeys',
        'realmadrid',
        'KAKA',
        'NASA',
        'FCBarcelona',
        'ConanOBrien',
        'EmmaWatson',
        'chrisbrown',
        'Adele',
        'kanyewest',
        'NBA',
        'ActuallyNPH',
        'zaynmalik',
        'pitbull',
        'danieltosh',
        'akshaykumar',
        'KendallJenner',
        'PMOIndia',
        'khloekardashian',
        'sachin_rt',
        'KylieJenner',
        'imVkohli',
        'coldplay',
        'NFL',
        'deepikapadukone',
        'kourtneykardash',
        'iHrithik',
        'BBCWorld',
        'aamir_khan',
        'TheEconomist',
        'andresiniesta8',
        'POTUS',
        'MesutOzil1088',
        'Eminem',
        'HillaryClinton',
        'priyankachopra',
        'NatGeo',
        'AvrilLavigne',
        'davidguetta',
        'elonmusk',
        'MohamadAlarefe',
        'ChampionsLeague',
        'NICKIMINAJ',
        'MariahCarey',
        'blakeshelton',
        'ricky_martin',
        'Google',
        'edsheeran',
        'arrahman',
        'Reuters',
        'AlejandroSanz',
        'LeoDiCaprio',
        'Dr_alqarnee',
    ];

    protected function get_seed_user()
    {
        $last_user = User::latest()->first();
        $seed_user_json = Twitter::getUsers(['screen_name' => $last_user->slug, 'format' => 'json']);
        $seed_user = json_decode($seed_user_json);

        return $seed_user;
    }

    public function run()
    {
        foreach ($this->seed_users_origin as $seed_user) {
            if ($this->seed_user_info($seed_user)) {
                $this->seed_user_tweets($seed_user, 100);
            }
        }
    }

    protected function seed_user_info($twitter_username)
    {
        $seed_user_json = Twitter::getUsers(['screen_name' => $twitter_username, 'format' => 'json']);
        $seed_user = json_decode($seed_user_json);

        $user = new User;
        $data = [
            'name' => $seed_user->name,
            'slug' => $seed_user->screen_name,
            'email' => $faker = Faker\Factory::create()->email,
            'description' => $seed_user->description,
            'json_raw' => $seed_user_json,
            //'avatar_origin' => $seed_user->profile_image_url,
            'avatar_origin' => str_replace('_normal.jpg','_400x400.jpg', $seed_user->profile_image_url),
            'password' => Hash::make('test'),
        ];

        $new_user = $user->updateOrCreate(['slug' => $twitter_username], $data);
        if ($new_user AND $new_user->get_and_store_avatar()) {
            return $new_user->slug;
        }
    }

    protected function seed_user_tweets($twitter_username, $tweets_count = 30)
    {
        $user = User::where('slug', $twitter_username)->firstOrFail();

        $tweets = Twitter::getUserTimeline([
            'screen_name' => $user->slug,
            'count' => $tweets_count,
            'format' => 'json',
        ]);
        $tweets = json_decode($tweets);

        foreach ($tweets as $tweet) {
            $data = [
                'id' => $tweet->id,
                'json_raw' => json_encode($tweet),
                'content' => $tweet->text,
                'user_id' => $user->id,
                'created_at' => strtotime($tweet->created_at),
                'updated_at' => strtotime($tweet->created_at),
            ];

            Tweet::updateOrCreate(['id' => $tweet->id], $data);
        }
    }
}