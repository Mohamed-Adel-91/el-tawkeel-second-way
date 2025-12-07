<?php

namespace App\Http\Middleware;

use App\Support\GuestToken;
use Closure;

class EnsureGuestTracking
{
    public function handle($request, Closure $next)
    {
        GuestToken::resolve(); // ensures cookie + session id available
        return $next($request);
    }
}
