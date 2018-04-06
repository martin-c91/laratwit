<?php

use Illuminate\Database\Seeder;

class TweetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Tweet::class, 30)->create();
    }
}
