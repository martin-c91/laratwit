<?php

namespace Tests\Feature;

class UserTest extends \PassportTestCase
{
    public function testDatabase()
    {
        $this->assertInstanceOf(\App\User::class, $this->user1);

        $this->assertDatabaseHas('users', [
            'slug' => $this->user1->slug,
        ]);
    }

    public function testApiLogin()
    {
        $body = [
            'username' => $this->user2->slug,
            'password' => 'test',
        ];
        $response = $this->json('POST', '/api/auth/login', $body, ['Accept' => 'application/json']);

        //$test = \DB::table('oaUTH_PERSONAL_ACCESS_CLIENTS')->GET();
        //DD($TEST);
        //dd($response->content());
        $response->assertStatus(200)->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token',
        ]);
    }

    public function testApiLogout()
    {
        $response = $this->getJson('api/auth/logout');
        $response->assertStatus(200);
        $response->assertJson(
            ["message"=>"successfully logged out"]
        );
    }

}
