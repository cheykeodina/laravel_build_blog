<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $channelSlug
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelSlug, Thread $thread)
    {
        $thread->addReply([
            'body' => \request('body'),
            'user_id' => auth()->user()->id
        ]);
        return back();
    }
}
