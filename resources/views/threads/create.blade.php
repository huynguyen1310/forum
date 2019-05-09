@extends('layouts.app')

@section('header')
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Threads</div>

                <div class="card-body">
                    <form action="/threads" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="channel_id">Channel</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Chose One...</option>
                                @foreach (App\Channel::all() as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>                                    
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" class="form-control" placeholder="title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="body">Body</label>
                            <wysiwyg name="body"></wysiwyg>
                        </div>

                        <button class="btn btn-primary">Submit</button>
                        @if (count($errors))
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </form>

                    
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
