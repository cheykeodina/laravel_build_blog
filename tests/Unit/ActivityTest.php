<?php

namespace Tests\Unit;

use App\Activity;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_creates_activity_when_a_thread_is_created()
    {
        $user = $this->signIn();
        $thread = create(Thread::class);
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);
        $activity = Activity::first();
        $this->assertEquals($activity->subject_id, $thread->id);
    }

    /** @test */
    public function it_record_activity_when_a_reply_is_created()
    {
        $this->signIn();
        $reply = create(Reply::class);
        // when we create a reply in model factory it need to create a thread as well
        // so in activity table it must have two records
        $this->assertEquals(2, Activity::count());
    }
}
