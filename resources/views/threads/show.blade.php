@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="">{{ $thread->creator->name }}</a> posted: 
                    {{ $thread->title }}
                </div>
                <div class="card-body">
                        <article>
                            <div class="body">{{ $thread->body }}</div>
                        </article>
                </div>
            </div>
        </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($thread->replies as $rely)
                <div class="card mb-4">
                    @include('threads.reply')
                </div>
            @endforeach
            
        </div>
        </div>
    </div>

    @if (auth()->check())
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ $thread->path() . '/replies' }}" method="post">
                    @csrf
                    <textarea name="body" id="" class="form-control" placeholder="Have somethin to say ?"></textarea>
                    <button class="btn btn-success mt-2">Post</button>
                </form>
            </div>
            </div>
        </div>
    @else
        <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
    @endif
    
</div>
@endsection
