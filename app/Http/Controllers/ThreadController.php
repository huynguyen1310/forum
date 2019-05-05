<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use App\Channel;
use App\User;
use App\Filters\ThreadFilter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

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
    public function index(Channel $channel , ThreadFilter $filters)
    {
        $threads = $this->getThreads($channel,$filters);

        if(request()->wantsJson()) {
            return $threads;
        }

        $trending = collect(Redis::zrevrange('trending_threads' , 0 , 4))->map(function ($thread) {
            return json_decode($thread);
        });
        
        return view('threads.index',compact('threads' , 'trending'));
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
        $this->validate($request, [
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
        


        return redirect($thread->path())
                ->with('flash','Your thread has been publish!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId , Thread $thread)
    {   
        if(auth()->check()){
            auth()->user()->read($thread);
        }

        Redis::zincrby('trending_threads' , 1 , json_encode([
            'title' => $thread->title,
            'path' => $thread->path()
        ]));
        
        return view('threads.show',compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
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
