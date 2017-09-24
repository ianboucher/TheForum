<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAGuestUserCannotCreateNewThreads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make('App\Thread'); // uses custom helper in tests/utilities/functions.php

        $this->post('/threads', $thread->toArray());
    }

    public function testAGuestUserCannotSeeTheCreateThreadForm()
    {
        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAnAuthenticatedUserCanCreateNewThreads()
    {
        $this->signIn();
        $thread = create('App\Thread');

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
