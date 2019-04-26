@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="page-header">
                <h1>{{ $profileUser->name }}</h1>
                Since <small>{{ $profileUser->created_at->diffForHumans() }}</small>
            </div>
            @foreach ($threads as $thread)
            <div class="card mt-4">
                <div class="card-header">
                    <div class="level">
                        <div class="flex">
                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a> | Posted : 
                            <span>{{ $thread->created_at->diffForHumans() }}</span>
                        </div> 
                    </div>

                </div>
                <div class="card-body">
                    <article>
                        <div class="body">{{ $thread->body }}</div>
                    </article>
                </div>
            </div>
            @endforeach
            <br>
            {{ $threads->links() }}
        </div>
    </div>

</div>

@endsection
