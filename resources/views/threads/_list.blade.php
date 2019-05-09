@forelse ($threads as $thread)
    <div class="card mb-4">
        <div class="card-header level">
            <div class="flex">
                <h3>
                    <a href="{{ $thread->path() }}">
                        @if (auth()->check() && $thread->hasUpdatedFor(auth()->user()))
                            <strong>
                                {{ $thread->title }}
                            </strong>
                        @else
                            {{ $thread->title }}
                        @endif                                         
                    </a>
                </h3>
                
                <h4>Posted by : <a href="{{ route('profile' , $thread->creator) }}">{{ $thread->creator->name }}</a></h4>
            </div>
            <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('reply',$thread->replies_count) }}</a>
        </div>
        <div class="card-body">{!! $thread->body !!}</div>

        <div class="card-header">
            {{ $thread->visits()->count() }} Visits
        </div>
    </div>
@empty
    <p>There are no relevent result at this time</p>
@endforelse