@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Forum Threads</div>
                    <div class="panel-body">
                        @foreach($threads as $thread)
                            <article>
                                <div class="level" style="display: flex;align-items: center">
                                    <h4 class="flex" style="flex: 1">
                                        <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                    </h4>
                                    <a href="{{ $thread->path() }}"><strong>{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</strong></a>
                                </div>
                                <div>
                                    {{ $thread->body }}
                                </div>
                            </article>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
