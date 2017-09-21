<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanViewAllThreads()
    {
        $response = $this->get('/threads');

        $response->assertStatus(200);
        $response->assertSee($this->thread->title);
    }

    public function testUserCanViewASingleThread()
    {
        $response = $this->get('/threads/' . $this->thread->id);

        $response->assertStatus(200);
        $response->assertSee($this->thread->title);
    }

    public function testUserCanViewRepliesToAThread()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);
        $response = $this->get('/threads/' . $this->thread->id);

        $response->assertSee($reply->body);
    }
}
