<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\ActivityLogger;
use Illuminate\Auth\Events\Logout;

class LogUserLogout
{
    /**
     * Create the event listener.
     */
    public function handle(Logout $event)
    {
        ActivityLogger::log(
            action: 'logout',
            module: 'auth',
            description: "{$event->user->name} logout dari sistem"
        );
    }
}
