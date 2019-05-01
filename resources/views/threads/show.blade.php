@extends('layouts.app')

@section('content')
<thread-view inline-template :initial-replies-count="{{ $thread->replies_count }}">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <div class="flex">
                                <a href="{{ route('profile',$thread->creator->name) }}">{{ $thread->creator->name }}</a> posted: 
                                {{ $thread->title }}
                            </div>
                                @can('update', $thread)
                                    <form action="{{ $thread->path() }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                @endcan
                            
                        </div>
                    </div>
                    <div class="card-body">
                            <article>
                                <div class="body">{{ $thread->body }}</div>
                            </article>
                    </div>
                </div>
    
                <replies @added="repliesCount++" @removed="repliesCount--"></replies>
    
                
                
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>This thread was Published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a> , 
                            and currently has <span v-text="repliesCount"></span> {{ str_plural('comment',$thread->replies_count) }} .
                        </p>

                        <p>
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</thread-view>

@endsection
