<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

use App\Users;

class UserTest extends TestCase
{
    /** @test */
    public function user_exist()
    {
        $user = \App\User::where('slug', $this->user1->slug)->get()->first();

        $this->assertEquals($this->user1->id, $user->id);
    }

    /** @test */
    public function user_can_upload_avatar_to_assets()
    {
        $this->assertTrue($success = $this->user1->get_and_store_avatar());

        //dd(($this->user1->avatar));
        $this->assertTrue($success, "Storage Failed");
        $this->assertNotEquals($this->user1->avatar, asset('storage/images/avatars/default.png'));
        $this->assertFileExists(public_path($this->user1->avatar), 'Avatar could not be found.');
    }
}