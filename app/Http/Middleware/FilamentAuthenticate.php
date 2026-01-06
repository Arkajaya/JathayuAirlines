<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilamentAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        // If not logged in, redirect to Filament login page
        if (! Auth::check()) {
            return redirect()->route('filament.admin.auth.login');
        }

        $user = Auth::user();
        try {
            if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
                return $next($request);
            }
            if (method_exists($user, 'hasRole') && ($user->hasRole('Staff') || $user->hasRole('staff'))) {
                return $next($request);
            }
        } catch (\Throwable $e) {
            // deny on error
        }

        abort(403, 'Akses ditolak.');
    }
}
