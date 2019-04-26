@extends('layouts.app')

@section('content')
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

            @foreach ($replies as $reply)
                <div class="card mb-4 mt-4">
                    @include('threads.reply')
                </div>
            @endforeach
            {{ $replies->links() }}
            
            @if (auth()->check())
                <form action="{{ $thread->path() . '/replies' }}" method="post" class="mt-4">
                    @csrf
                    <textarea name="body" id="" class="form-control" placeholder="Have somethin to say ?"></textarea>
                    <button class="btn btn-success mt-2">Post</button>
                </form>
            @else
                <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>This thread was Published {{ $thread->created_at->diffForHumans() }} by
                        <a href="#">{{ $thread->creator->name }}</a> , 
                        and currently has {{ $thread->replies_count }} {{ str_plural('comment',$thread->replies_count) }} .
                    </p>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
