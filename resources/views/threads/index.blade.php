@extends('layouts.app')

@section('content')
    {{--<example></example>--}}
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @forelse($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level" style="display: flex;align-items: center">
                                <h4 class="flex" style="flex: 1">
                                    <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                </h4>
                                <a href="{{ $thread->path() }}"><strong>{{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}</strong></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                @empty
                    <p>There is no thread found.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
