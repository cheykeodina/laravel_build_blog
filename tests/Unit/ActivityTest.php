<?php

namespace Tests\Unit;

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
        $this->signIn();
        $thread = create(Thread::class);
        $this->assertDatabaseHas('activities', [
            'type' => 'create_thread',
            'user_id' => auth()->id(),

        ]);
    }
}
