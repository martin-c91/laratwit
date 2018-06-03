<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class followingTest extends TestCase
{

    public function test_user1_and_2_exist()
    {
        $this->assertInstanceOf('\App\User', $this->user1);
        $this->assertInstanceOf('\App\User', $this->user2);
    }

    /** @test */
    public function users_can_follow_each_other()
    {
        $this->user1->follow($this->user2);
        $this->assertEquals($this->user2->id, ($this->user1->followings()->where('id', $this->user2->id)->first()->id));
    }

    /** @test */
    public function users_can_un_follow_each_other()
    {
        $this->user1->unFollow($this->user2);
        $result = $this->user1->followings()->where('id', $this->user2->id)->first();
        $this->assertEmpty($result);
    }
}