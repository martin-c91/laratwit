<?php

use Illuminate\Database\Seeder;

class TweetsSeeder extends Seeder
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

    }
}
