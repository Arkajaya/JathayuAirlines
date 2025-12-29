<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\ActivityLogger;

class LogAuthLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;
        ActivityLogger::log($user->id ?? null, 'auth.login', 'User logged in');
    }
}
