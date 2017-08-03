@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{$activity->subject->favorited->path()}}">{{ $profileUser->name }} favorited a reply</a>
    @endslot
    @slot('body')
        Leave a reply
    @endslot
@endcomponent