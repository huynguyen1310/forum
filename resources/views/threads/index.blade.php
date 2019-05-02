@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                    <div class="card-header">Forum Threads</div>
                
                <div class="card-body">
                    @forelse ($threads as $thread)
                        <article>
                            <div class="level">
                                    <h3 class="flex">
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

                                    <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('reply',$thread->replies_count) }}</a>
                            </div>
                            
                            <div class="body">{{ $thread->body }}</div>
                        </article>
                        <hr>
                    @empty
                        <p>There are no relevent result at this time</p>
                    @endforelse
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
