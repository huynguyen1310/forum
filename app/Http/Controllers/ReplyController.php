<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;
use App\Inspections\Spam;
use Illuminate\Auth\Access\Gate;

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

    public function store($channelId, Thread $thread, Spam $spam)
    {

        try {
            request()->validate(['body' => 'required|spamfree']);

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);
        } catch (\Exception $e) {
            return response("your reply could not be saved at this time", 422);
        }


        return $reply->load('owner');
    }

    public function update(Reply $reply, Spam $spam)
    {

        $this->authorize('update', $reply);

        try {
            request()->validate(['body' => 'required|spamfree']);

            $reply->update(request(['body'])); //code...
        } catch (\Exception $e) {
            return response("your reply could not be saved at this time", 422);
        }
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
