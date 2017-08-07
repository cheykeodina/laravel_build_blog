<reply :attributes="{{ $reply }} "inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="panel panel-default">
        <div class="panel-heading">
            <div class="level" style="display: flex;align-items: center">

                <div style="flex: 1">
                    <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->name }}</a>
                    said {{ $reply->created_at->diffForHumans() }}
                </div>
                <div>
                    <form method="post" action="/replies/{{$reply->id}}/favorites">
                        {{ csrf_field() }}
                        <button type="submit"
                                class="btn btn-sm btn-default" {{ $reply->isFavorited() ? 'disabled':'' }}>
                            {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count ) }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body">
                {{ $reply->body }}
            </div>
        </div>

        @can('update', $reply)
            <div class="panel-footer" style="display: flex; align-items: center">
                <button class="btn btn-xs" @click="editing = true" style="margin-right: 5px;">Edit</button>
                <button class="btn btn-danger btn-xs" @click="destroy">Delete</button>
            </div>
        @endcan
    </div>
</reply>