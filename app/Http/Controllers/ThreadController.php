<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use App\Channel;
use App\Filters\ThreadFilter;
use App\Trending;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel , ThreadFilter $filters , Trending $trending)
    {
        $threads = $this->getThreads($channel,$filters);

        if(request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index',[
            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
        ]);
        
        if(request()->wantsJson()) {
            return response($thread,201);
        }


        return redirect($thread->path())
                ->with('flash','Your thread has been publish!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId , Thread $thread , Trending $trending)
    {   
        if(auth()->check()){
            auth()->user()->read($thread);
        }

        $trending->push($thread);

        $thread->visits()->record();
        
        return view('threads.show',compact('thread'));
    }

    public function update($channel , Thread $thread)
    {
        $this->authorize('update',$thread);

        $data = request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
        ]);

        $thread->update($data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel,Thread $thread)
    {
        $this->authorize('update',$thread);
        // $thread->replies()->delete();
        $thread->delete();

        return redirect('/threads');
    }

    protected function getThreads($channel,$filter) {
        $threads = Thread::latest()->filter($filter);

        if($channel->exists){
            $threads->where('channel_id',$channel->id);
        }

        return $threads->paginate(25);
    }
}
