<?php

namespace Tests\Unit;

use App\Activity;
use App\Reply;
use App\Thread;
use Carbon\Carbon;
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

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();
        create(Thread::class, ['user_id' => auth()->id()], 2);
//        create(Thread::class, ['user_id' => auth()->id(), 'created_at' => Carbon::now()->subWeek()]);

        auth()->user()->activities()->first()->update(['created_at' => Carbon::now()->subWeek()]);
        $feed = Activity::feed(auth()->user());
        $this->assertTrue($feed->keys()->contains(Carbon::now()->format('Y-m-d')));
        $this->assertTrue($feed->keys()->contains(Carbon::now()->subWeek()->format('Y-m-d')));

    }
}
