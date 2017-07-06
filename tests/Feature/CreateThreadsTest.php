<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_create_a_thread()
    {
//        $this->expectException('Illuminate\Auth\AuthenticationException');
//        $thread = make(Thread::class);
//        // Post endpoint
//        $this->post('/threads', $thread->toArray());
        $this->withExceptionHandling();
        $this->get('/threads/create')->assertRedirect('/login');
        $this->post('/threads')->assertRedirect('/login');
    }

    /** @test */
    public function guests_can_not_see_create_thread_page()
    {
        $this->withExceptionHandling()->get('threads/create')->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        // User signed in
        $this->be(create(User::class));
        // Have thread
        $thread = create(Thread::class);
        // Post endpoint
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())->assertSee($thread->title)->assertSee($thread->body);

    }
}
