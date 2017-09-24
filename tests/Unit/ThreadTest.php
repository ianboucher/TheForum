<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    public function testAThreadCanReturnItsPath()
    {
        $this->assertEquals(
            "/threads/{$this->thread->channel->slug}/{$this->thread->id}",
            $this->thread->path());
    }

    public function testAThreadHasAnOwner()
    {
        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    public function testAThreadHasReplies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function testAThreadCanAddAReply()
    {
        $this->thread->replies()->create([
            'body' => 'Test body',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function testAThreadBelongsToAChannel()
    {
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }
}
