<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Login;

class LogUserLogin
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        ActivityLogger::log(
            action: 'login',
            // module: 'Users',
            module: 'Auth',
            description: "{$event->user->name} login ke sistem",
        );
    }
}
