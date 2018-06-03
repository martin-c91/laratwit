<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $user1;

    public $user2;

    protected function setUp()
    {
        parent::setUp(); // this is important!

        //$this->user1 = factory(\App\User::class)->create();
        //$this->user2 = factory(\App\User::class)->create();
        $this->user1 = \App\User::where('slug', 'justinbieber')->first();
        $this->user2 = \App\User::where('slug', 'katyperry')->first();
        $this->actingAs($this->user1);
    }

    public function tearDown()
    {
        unset($this->user1);
        unset($this->user2);
    }

}
