<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserAvatarController extends Controller
{

    public function store(User $user) {
        request()->validate([
            'avatar' => ['required','image']
        ]);

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars','public')
        ]);
            
        return response([] , 204);
    }
}
