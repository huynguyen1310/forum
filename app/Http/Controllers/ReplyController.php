<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreatePostRequest;
use App\Notifications\YouWereMentioned;
use App\User;

class ReplyController extends Controller
{
    function __constructor()
    {
        $this->middleware('auth');
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    public function store($channelId, Thread $thread , CreatePostRequest $form)
    {
        if($thread->locked){
            return response('Thread is locked',422);
        }   
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');
        
    }

    public function update(Reply $reply)
    {

        $this->authorize('update', $reply);

        
        request()->validate(['body' => 'required|spamfree']);

        $reply->update(request(['body'])); //code...
        
    }

    public function destroy(Reply $reply)
    {

        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }
}
