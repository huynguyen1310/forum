@component('profile.activities.activity')
    @slot('heading')
    {{ $profileUser->name }} replies to thread <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a> 
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
