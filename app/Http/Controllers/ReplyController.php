<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;

class ReplyController extends Controller
{
    function __constructor() {
        $this->middleware('auth');
    }

    public function store($channelId ,Thread $thread) {
        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        
        return back();
    }

    public function update(Reply $reply) {
        $this->authorize('update',$reply);

        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply) {

        $this->authorize('update',$reply);

        $reply->delete();

        if(request()->expectsJson()){
            return response(['status'=>'Reply deleted']);
        }

        return back();
    }
}
