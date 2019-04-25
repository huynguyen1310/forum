<?php 

namespace App\Filters;

use Illuminate\Http\Request;
use App\User;

class ThreadFilter extends Filter{

    protected $filters = ['by','popular'];

    public function by($username) {
        $user = User::where('name',$username)->firstOrFail();

        return $this->builder->where('user_id',$user->id);
    }

    public function popular(){
        $this->builder->getQuery()->orders = [];
        $this->builder->orderBy('replies_count','desc');
    }
}