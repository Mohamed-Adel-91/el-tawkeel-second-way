<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;

class GuestBroadcastAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            ['cluster' => env('PUSHER_APP_CLUSTER', 'mt1'), 'useTLS' => true]
        );

        $user = auth()->user();
        $sid  = $request->session()->getId();

        $userId   = $user->id ?? 'guest:'.substr($sid, 0, 12);
        $userInfo = ['name' => $user->name ?? 'Guest-'.substr($sid, 0, 6)];

        $auth = $pusher->presence_auth(
            $request->input('channel_name'),
            $request->input('socket_id'),
            $userId,
            $userInfo
        );

        return response($auth, 200)->header('Content-Type', 'application/json');
    }
}

