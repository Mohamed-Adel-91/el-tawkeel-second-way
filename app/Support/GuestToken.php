<?php

namespace App\Support;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class GuestToken
{
    public static function resolve(): array
    {
        $sessionId = session()->getId();
        $token = request()->cookie('guest_token');

        if (!$token) {
            $token = (string) Str::uuid();
            Cookie::queue(cookie('guest_token', $token, 60 * 24 * 30));
        }

        return [$sessionId, $token];
    }

    public static function token(): string
    {
        [, $token] = self::resolve();
        return $token;
    }

    public static function sessionId(): string
    {
        return session()->getId();
    }
}
