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

        $thread = make('App\Thread'); // make not create - create persists immediately

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location')) // can't use $thread->path() due to 'make' above
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAThreadRequiresATitle()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAThreadRequiresABody()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAThreadRequiresAValidChannelId()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    private function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
