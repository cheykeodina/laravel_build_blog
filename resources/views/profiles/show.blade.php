@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>
                {{ $profileUser->name }}
                <small>{{ $profileUser->created_at->diffForHumans() }}</small>
            </h1>
        </div>
        @foreach($threads as $thread)
            <div class="panel panel-default">
                <div class="panel-heading" style="display: flex;align-items: center">
                    <h5 style="flex: 1;">
                        <a href="/profiles/{{$thread->creator->name}}">{{ $thread->creator->name }}</a> posted:{{ $thread->title }}
                    </h5>
                    <strong>{{$thread->created_at->diffForHumans() }}</strong>
                </div>
                <div class="panel-body">
                    {{ $thread->body }}
                </div>
            </div>
        @endforeach
        {{ $threads->links() }}
    </div>
@endsection