<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Users;

class UserTest extends TestCase
{
    protected $user_slug = 'justinbieber';
    protected $user_id = 3;

    /** @test */
    public function test_user_exist()
    {
        $this->assertDatabaseHas('users', [
            'slug' => 'justinbieber'
        ]);
    }

    /** @test */
    public function user_exist()
    {
        $user = \App\User::where('slug', $this->user_slug)->get()->first();

        $this->assertEquals($user->id, $this->user_id);
    }

    /** @test */
    public function user_can_login()
    {
        $credential = [
            'username' => 'justinbieber',
            'password' => 'test'
        ];

        $response = $this->post('login',$credential);

        $response->dump();
        $response->assertSessionMissing('errors');
    }

    public function testLoginFalse()
    {
        $credential = [
            'email' => 'user@ad.com',
            'password' => 'incorrectpass'
        ];

        $response = $this->post('login',$credential);

        $response->assertSessionHasErrors();
    }
}