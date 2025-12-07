<?php

namespace App\Listeners;

use App\Models\Guest;
use App\Models\Order;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;

class AttachGuestData
{
    public function handle(Login|Registered $event): void
    {
        $user = $event->user;
        if (! $user instanceof \App\Models\User) {
            return;
        }

        $sessionId = session()->getId();
        $guestToken = request()->cookie('guest_token');

        Order::whereNull('user_id')
            ->where(function ($q) use ($sessionId, $guestToken) {
                $q->where('session_id', $sessionId)
                    ->orWhere('guest_token', $guestToken);
            })
            ->update(['user_id' => $user->id]);

        Guest::whereNull('user_id')
            ->where(function ($q) use ($sessionId, $guestToken) {
                $q->where('session_id', $sessionId)
                    ->orWhere('guest_token', $guestToken);
            })
            ->update(['user_id' => $user->id]);
    }
}
