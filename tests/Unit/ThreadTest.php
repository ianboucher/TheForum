<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function testAThreadHasReplies()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }

    public function testAThreadHasAnOwner()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\User', $thread->owner);
    }

    public function testAThreadCanAddAReply()
    {
        $thread = factory('App\Thread')->create();

        $thread->replies()->create([
            'body' => 'Test body',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $thread->replies);
    }
}
