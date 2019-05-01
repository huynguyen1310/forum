<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;

class UserNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return auth()->user()->unreadNotifications;
    }

    public function destroy(User $user, $notificationId) {

        return auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
