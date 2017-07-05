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
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        // User signed in
        $this->be(factory(User::class)->create());
        // Have thread
        $thread = factory(Thread::class)->make();
        // Post endpoint
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())->assertSee($thread->title)->assertSee($thread->body);

    }
}
