<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ForumParticipatonTest extends TestCase
{
    use DatabaseMigrations;

    function testUnauthenticatedUserCannotParticipateInThreads()
    {
        $thread = factory('App\Thread')->create();

        $this->withExceptionHandling()
            ->post($thread->path() . '/replies', [])
            ->assertRedirect('/login');
    }

    public function testAuthenticatedUserCanParticipateInThreads()
    {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();
        $reply  = factory('App\Reply')->make();

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(302); //redirect to thread page

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
