<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;
use App\Events\ThreadHasNewReply;

class Thread extends Model
{
    use RecordActivity;

    protected $guarded = [];

    protected $with = ['creator','channel'];

    protected $appends = ['isSubscribedTo'];

    public static function boot() {
        parent::boot();

        static::deleting(function ($thread){
            $thread->replies->each->delete();
        });
    }

    public function path() {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }

    public function creator() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function addReply($reply) {
        $reply = $this->replies()->create($reply);

        // event(new ThreadHasNewReply($this,$reply)); Use event listener 

        $this->notifySubscribers($reply);

        return $reply;
    } 

    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query,$filters) {
            return $filters->apply($query);
    }

    public function subscribe($userId = null) {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
    }

    public function unSubscribe($userId = null) {
        $this->subscriptions()
            ->where('user_id' , $userId ?: auth()->id())
            ->delete(); 
    }

    public function subscriptions() {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute() {
        return $this->subscriptions()
                ->where('user_id',auth()->id())
                ->exists();
    }
    
    public function notifySubscribers($reply) {
        $this->subscriptions
            ->where('user_id','!=',$reply->user_id)
            ->each
            ->notify($reply);
    }

    public function hasUpdatedFor($user) {
        $key = $user->visitedCacheKey($this);

        return $this->updated_at > cache($key);
    }
}
