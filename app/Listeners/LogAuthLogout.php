<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Services\ActivityLogger;

class LogAuthLogout
{
    public function handle(Logout $event)
    {
        $user = $event->user;
        ActivityLogger::log($user->id ?? null, 'auth.logout', 'User logged out');
    }
}
