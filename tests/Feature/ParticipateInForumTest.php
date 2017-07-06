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
}
