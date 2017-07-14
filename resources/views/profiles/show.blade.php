@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h3>
                {{ $profileUser->name }}
                <small>{{ $profileUser->created_at->diffForHumans() }}</small>
            </h3>
        </div>
        @foreach($threads as $thread)
            <div class="panel panel-default">
                <div class="panel-heading" style="display: flex;align-items: center">
                    <h5 style="flex: 1;">
                        <a href="/profiles/{{$thread->creator->name}}">{{ $thread->creator->name }}</a> posted:
                        <a href="{{ $thread->path()}}">{{ $thread->title }}</a>
                        <strong>{{$thread->created_at->diffForHumans() }}</strong>
                    </h5>
                    @if(auth()->check())
                        <form action="{{ $thread->path() }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-link">Delete thread</button>
                        </form>
                    @endif
                </div>
                <div class="panel-body">
                    {{ $thread->body }}
                </div>
            </div>
        @endforeach
        {{ $threads->links() }}
    </div>
@endsection