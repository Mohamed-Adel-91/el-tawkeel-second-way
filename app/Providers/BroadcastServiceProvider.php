<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\GenericUser;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes([
            'middleware' => ['web'],
        ]);

        Broadcast::resolveAuthenticatedUserUsing(function ($request) {
            if ($request->user()) {
                return $request->user();
            }
            $sid = $request->session()->getId();
            return new GenericUser([
                'id'   => 'guest:' . substr($sid, 0, 12),
                'name' => 'Guest-' . substr($sid, 0, 6),
            ]);
        });

        require base_path('routes/channels.php');
    }
}
