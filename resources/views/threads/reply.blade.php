<div class="card-header">
        <a href="#">{{ $rely->owner->name }}</a> said {{ $rely->created_at->diffForHumans() }}
    </div>
    <div class="card-body">
        {{ $rely->body }}
    </div>