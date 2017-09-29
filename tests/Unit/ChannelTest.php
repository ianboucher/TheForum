<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_channel_has_many_threads()
    {
        $channel = create('App\Channel');
        $thread  = create('App\Thread', ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }
}
