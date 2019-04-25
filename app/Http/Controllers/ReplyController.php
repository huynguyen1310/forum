<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

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
}
