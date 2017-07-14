<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordActivity;
    protected $guarded = [];
    // App\Thread::withoutGlobalScopes()->first(); is not working with ths pattern
    protected $with = ['creator', 'channel', 'replies'];

    protected static function boot()
    {
        // Add Global Scope to model to reduce sql query
        parent::boot();
        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
        // App\Thread::withoutGlobalScopes()->first(); is working with this pattern
        /*static::addGlobalScope('creator', function ($builder) {
            $builder->with('creator');
        });*/

        // when deleting a thread it must delete all associated replies
        static::deleting(function ($thread) {
            $thread->replies()->delete();
        });

        // create activity when thread is created
//        static::created(function ($thread) {
//            $thread->recordActivity('created');
//
//        });
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }
}
