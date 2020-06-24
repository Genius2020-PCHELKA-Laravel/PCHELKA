<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications;
use App\Notifications\ExpoNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $user = Auth::user();
        $key = "ExponentPushToken[rplFsYMBUnIcHy8J-jPsXV]";
        $user->notify(new ExpoNotification());
    }
}
