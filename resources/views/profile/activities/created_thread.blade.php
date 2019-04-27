@component('profile.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} publish <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a> 
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent