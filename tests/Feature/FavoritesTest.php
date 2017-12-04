<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    public function testGuestsCannotFavoriteAnything() 
    {
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserCanFavoriteAnyReply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    public function testAnAuthenticatedUserCanFavoriteAReplyOnlyOnce()
    {
        $this->signIn();
        
        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favorites');
        $this->post('replies/' . $reply->id . '/favorites');        

        $this->assertCount(1, $reply->favorites);
    }
}