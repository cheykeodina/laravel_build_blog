<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_authenticated_user_may_participate_in_forum_thread()
    {
//        $user = create(User::class);
        $this->signIn();
        $thread = create(Thread::class);
        $reply = create(Reply::class);
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling();
        $this->post('/threads/vilot/1/replies', [])->assertRedirect('/login');
    }

    /** @test */
    public function unauthorized_user_can_not_delete_reply()
    {
        $this->withExceptionHandling();
        $reply = create(Reply::class);

        $this->delete("/replies/{$reply->id}")->assertRedirect('login');
        $this->signIn()->delete("/replies/{$reply->id}")->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_reply()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function unauthorized_user_can_not_update_reply()
    {
        $this->withExceptionHandling();
        $reply = create(Reply::class);

        $this->patch("/replies/{$reply->id}", ['body' => 'new body'])->assertRedirect('login');
        $this->signIn()->patch("/replies/{$reply->id}", ['body' => 'new body'])->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_update_reply()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $updateBody = 'new body';
        $this->patch("/replies/{$reply->id}", ['body' => $updateBody]);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updateBody]);
    }
}
