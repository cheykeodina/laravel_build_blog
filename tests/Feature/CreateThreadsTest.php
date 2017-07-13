<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
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

    /** @test */
    public function authorized_user_can_delete_thread()
    {
        $user = $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);
        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(200);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
    }

    /** @test */
    public function unauthorized_user_may_not_delete_a_thread()
    {
        $this->withExceptionHandling();
        $thread = create(Thread::class);
        $this->delete($thread->path())->assertRedirect('/login');

        $user = $this->signIn();
        $this->delete($thread->path())->assertRedirect('/login');

    }


}
