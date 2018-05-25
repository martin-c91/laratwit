<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TweetTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

        $this->assertTrue(true);
    }

    public function user_can_create_tweet()
    {
        $data = [
            user_slug = 'realDonaldTrump',
            content = 'YOOOO',
        ];

        $tweet = new Tweet;
        $tweet->create($data);

        $this->assertInstanceOf($tweet);
    }


}
