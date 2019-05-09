{{-- Editing the qusetion --}}
<div class="card" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input type="text" name="title" class="form-control" v-model="form.title">        
        </div>
    </div>
    <div class="card-body">
            <article class="form-group">
                <textarea class="form-control" name="body" rows="10" v-model="form.body"></textarea>
            </article>
    </div>

    <div class="card-footer level">
        <button class="btn btn-sm btn-primary" @click="editing = true" v-show="!editing">Edit</button>
        <button class="btn btn-sm btn-primary mr-2" @click="update">Update</button>
        <button class="btn btn-sm btn-link" @click="resetForm">Cancel</button>

        @can('update', $thread)
            <form action="{{ $thread->path() }}" method="POST" class="ml-auto">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger">Delete</button>
            </form>
        @endcan
    </div>
</div>

{{-- Viewing the qusetion --}}
<div class="card" v-else>
    <div class="card-header">
        <div class="level">
            <img src="/storage/{{ $thread->creator->avatar() }}" width="25" height="25" class="mr-1">

            <div class="flex">
                <a href="{{ route('profile',$thread->creator->name) }}">{{ $thread->creator->name }}</a> posted: 
                <span v-text="title"></span>
            </div>            
        </div>
    </div>
    <div class="card-body">
            <article>
                <div class="body" v-text="body"></div>
            </article>
    </div>

    <div class="card-footer" v-if="authorize('owns',thread)">
        <button class="btn btn-sm btn-primary" @click="editing = true">Edit</button>
    </div>
</div>