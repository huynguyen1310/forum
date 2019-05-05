@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="page-header">
                <avatar-form :user="{{ $profileUser }}"></avatar-form>
            </div>
            <hr>
            @forelse ($activities as $date => $activity)
                <h3 class="page-header mt-2">{{$date}}</h3>
                @foreach ($activity as $record)
                    @if (view()->exists("profile.activities.{$record->type}"))
                        @include("profile.activities.{$record->type}" , ['activity' => $record]) {{-- overdrive record with activity  --}}
                    @endif
                @endforeach
            @empty    
                <p>There is no activities for this user yet</p>
            @endforelse
        </div>
    </div>

</div>

@endsection
