<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level" style="display: flex;align-items: center">

            <div style="flex: 1">
                <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}
            </div>
            <div>
                <form method="post" action="/replies/{{$reply->id}}/favorites">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-sm btn-default" {{ $reply->isFavorited() ? 'disabled':'' }}>
                        {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count ) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="panel-body">
        {{ $reply->body }}
    </div>
</div>