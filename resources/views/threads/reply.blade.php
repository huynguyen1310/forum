<div class="card-header">
    <div class="level">
        <h5 class="flex">
            <a href="{{ route('profile',$reply->owner->name) }}">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}
        </h5>

        <div>
            <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                @csrf
                <button class="btn btn-success" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->getFavoritesCount() }} {{ str_plural('Favorite' ,  $reply->getFavoritesCount() ) }}
                </button>
            </form>
        </div>
    </div>
        
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>