<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class RegisterConfirmationController extends Controller
{
    public function index() {
        $user = User::where('confirmation_token' , request('token'))->first();
        
        if(!$user){
            return redirect(route('threads'))->with('flash','Unknow Token');            
        };

        $user->confirm();
        
        return redirect(route('threads'))->with('flash','Your account is confirmed! You may post to the forum');
    }
}