<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Favorite;

class FavoriteController extends Controller
{
    public function __constructor(){
        $this->middleware('auth');
    }

    public function store(Reply $reply) {
        // $reply->favorites()->create(['user_id' => auth()->id()]);
        $reply->favorite();

        return back();
    }

    public function destroy(Reply $reply) {
        $reply->unFavorite();
    }
}
