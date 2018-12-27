<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User as User;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    use WithFaker;

    public $user1;
    public $user2;

    protected $baseUrl = 'http://whatever';

    protected function setUp()
    {
        parent::setUp(); // this is important!
        //\Artisan::call('migrate');
        \Artisan::call('passport:install');
        //Artisan::call('db:seed');
        $users = factory(\App\User::class, 3)
            ->create()
            ->each(function (\App\User $user) {
                $user->tweets()->save(factory(\App\Tweet::class)->make());
                $user->tweets()->save(factory(\App\Tweet::class)->make());
                $user->tweets()->save(factory(\App\Tweet::class)->make());
            });
        $this->user1 = $users[0];
        $this->user2 = $users[1];
        $this->user1->follow($users[2]);

        //dd($this->user1);
        ////$this->user1 = \App\User::where('slug', 'justinbieber')->first();
        //$this->user2 = \App\User::where('slug', 'katyperry')->first();
        //dd($this->user2);
        //$this->actingAs($this->user1);
    }

    public function tearDown()
    {
        unset($this->user1);
        unset($this->user2);
    }
}
