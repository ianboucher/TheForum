<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanViewAllThreads()
    {
        $thread   = factory('App\Thread')->create();
        $response = $this->get('/threads');

        $response->assertStatus(200);
        $response->assertSee($thread->title);
    }

    public function testUserCanViewASingleThread()
    {
        $thread   = factory('App\Thread')->create();
        $response = $this->get('/threads/' . $thread->id);

        $response->assertStatus(200);
        $response->assertSee($thread->title);
    }
}
