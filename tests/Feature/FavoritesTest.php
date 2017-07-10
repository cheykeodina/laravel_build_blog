<?php

namespace Tests\Feature;

use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_unauthenticated_user_can_not_favorite()
    {
        $this->withExceptionHandling()->post('/replies/1/favorites')->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_reply()
    {
        $user = $this->signIn();
        $reply = create(Reply::class);
        // post to endpoint for inserting favorite
        $this->post('/replies/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
        // assert database has to make sure that reply has that favorite
    }

    /** @test */
    public function an_authenticated_user_can_add_favorite_once()
    {
        $user = $this->signIn();
        $reply = create(Reply::class);
        // post to endpoint for inserting favorite
        try {
            $this->post('/replies/' . $reply->id . '/favorites');
            $this->post('/replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('This not expect ');
        }
        $this->assertCount(1, $reply->favorites);
    }
}
