<?php

namespace Tests\Feature;

use App\Tweet;
use http\Env\Request;
use PassportTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TweetTest extends PassportTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUnauthorizedCannotPost()
    {
        $data = [
            'content' => $this->faker->unique()->text(),
        ];

        $response = $this->json('POST', 'api/timeline/store', $data);
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    public function testAuthorizedUserCanPost()
    {
        $fakeTweet = $this->faker->unique()->text();
        $body = [
            'content' => $fakeTweet,
        ];

        $response = $this->postJson('api/timeline/store', $body);

        //dd(json_decode($response->content())->content);
        $response->assertStatus(200);
        $this->assertEquals($fakeTweet, json_decode($response->content())->content);
    }

    public function test_user_can_like_other_post()
    {
        $tweet = $this->user2->tweets->first();

        $response = $this->postJson('api/like/'.$tweet->id);

        $response->assertStatus(200);
        $tweet_likes = (int) $response->content();

        $this->assertGreaterThan(0, $tweet_likes);
    }

    public function test_user_can_unlike_other_post()
    {
        $tweet = $this->user2->tweets->first();

        $response = $this->deleteJson('api/like/'.$tweet->id);

        $response->assertStatus(200);
    }
}
