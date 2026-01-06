<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Filament\Support\Facades\FilamentColor;
use Filament\Filament;
use Filament\Support\Colors\Color;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Observers\BookingObserver;
use App\Observers\CancellationObserver;
use App\Models\Booking;
use App\Models\Cancellation;
use App\Services\ActivityLogger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure existing users with role_id are assigned corresponding Spatie roles
        try {
            if (class_exists(Role::class)) {
                // map role_id to role name (adjust if your app uses different ids)
                $mapping = [
                    1 => ['Admin'],
                    2 => ['Staff'],
                    3 => ['User'],
                ];

                foreach ($mapping as $roleId => $names) {
                    $users = User::where('role_id', $roleId)->get();
                    foreach ($users as $u) {
                        foreach ($names as $rname) {
                            if (! $u->hasRole($rname)) {
                                try {
                                    $u->assignRole($rname);
                                } catch (\Exception $e) {
                                    // ignore assign errors (role may not exist)
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::debug('Role sync skipped: '.$e->getMessage());
        }

        // Register model observers for activity logging
        try {
            Booking::observe(BookingObserver::class);
            Cancellation::observe(CancellationObserver::class);
        } catch (\Throwable $e) {
            Log::debug('Observer registration skipped: '.$e->getMessage());
        }

        // Listen to auth login/logout events for simple activity logging
        try {
            Event::listen(Login::class, function ($event) {
                $user = $event->user ?? null;
                ActivityLogger::log($user->id ?? null, 'auth.login', 'User logged in');
            });

            Event::listen(Logout::class, function ($event) {
                $user = $event->user ?? null;
                ActivityLogger::log($user->id ?? null, 'auth.logout', 'User logged out');
            });
        } catch (\Throwable $e) {
            Log::debug('Auth event listeners skipped: '.$e->getMessage());
        }

        // Register Filament color palettes so fi-color-{name} utilities are available
        try {
            FilamentColor::register(Color::all());
        } catch (\Throwable $e) {
            Log::debug('Filament color registration skipped: '.$e->getMessage());
        }

        // Restrict access to Filament admin panel to admins/staff only
        try {
            if (class_exists('\Filament\Filament')) {
                Filament::auth(function () {
                    $user = auth()->user();
                    if (! $user) return false;
                    try {
                        if (method_exists($user, 'isAdmin') && $user->isAdmin()) return true;
                        if (method_exists($user, 'hasRole') && ($user->hasRole('Staff') || $user->hasRole('staff'))) return true;
                    } catch (\Throwable $e) {
                        return false;
                    }
                    return false;
                });
            }
        } catch (\Throwable $e) {
            Log::debug('Filament auth guard skipped: '.$e->getMessage());
        }

        // Ensure all requests to Filament path go through ProtectFilament middleware
        try {
            $router = $this->app->make('\Illuminate\Routing\Router');
            // Prepend so it runs early in the web group
            if (method_exists($router, 'prependMiddlewareToGroup')) {
                $router->prependMiddlewareToGroup('web', \App\Http\Middleware\ProtectFilament::class);
            } else {
                // Fallback: push to group
                $router->pushMiddlewareToGroup('web', \App\Http\Middleware\ProtectFilament::class);
            }
        } catch (\Throwable $e) {
            Log::debug('ProtectFilament middleware registration skipped: '.$e->getMessage());
        }

        // Bind Filament's Authenticate middleware to our stricter implementation
        try {
            $this->app->bind(\Filament\Http\Middleware\Authenticate::class, \App\Http\Middleware\FilamentAuthenticate::class);
        } catch (\Throwable $e) {
            Log::debug('Filament Authenticate binding skipped: '.$e->getMessage());
        }
    }
}
