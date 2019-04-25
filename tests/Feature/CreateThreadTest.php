<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;
    /** @test*/
    public function an_authicated_user_can_create_new_forum_thread()
    {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->make();
        $this->post('/threads' ,$thread->toArray());

        $this->get($thread->path());

        $this->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
