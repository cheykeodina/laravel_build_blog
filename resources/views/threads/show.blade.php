@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading" style="display: flex; align-items: center">
                        <h5 style="flex: 1">
                            <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                            posted:{{ $thread->title }}
                        </h5>
                        @if(auth()->check())
                            @can('update', $thread)
                                <form action="{{ $thread->path() }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-link">Delete thread</button>
                                </form>
                            @endcan
                        @endif
                    </div>
                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>
                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach
                {{ $replies->links() }}
                @if(auth()->check())
                    @can('update', $thread)
                    <form action="{{ $thread->path(). '/replies' }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?"
                                      rows="5"></textarea>
                        </div>
                        <button class="btn btn-default" type="submit">Post</button>
                    </form>
                    @endcan
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this
                        discussion.
                    </p>
                @endif
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>This thread was published {{ $thread->created_at->diffForHumans() }} by <a
                                    href="#">{{ $thread->creator->name }}</a> , and
                            currently
                            has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }} .</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
