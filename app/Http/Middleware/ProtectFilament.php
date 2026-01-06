<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProtectFilament
{
    public function handle(Request $request, Closure $next)
    {
        $adminPath = trim((string) config('filament.path', 'admin'), '/');
        $uri = trim($request->path(), '/');

        if ($adminPath !== '' && ($uri === $adminPath || str_starts_with($uri, $adminPath.'/'))) {
            // require authenticated admin/staff
            if (! Auth::check()) {
                return redirect()->route('login');
            }
            $user = Auth::user();
            try {
                if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
                    return $next($request);
                }

                // Staff can access general Filament panel, but restrict certain admin-only resources
                if (method_exists($user, 'hasRole') && ($user->hasRole('Staff') || $user->hasRole('staff'))) {
                    // check first path segment after admin
                    $relative = preg_replace('#^'.preg_quote($adminPath,'#').'/?#', '', $uri);
                    $first = explode('/', $relative)[0] ?? '';
                    $adminOnly = ['users', 'activity-logs', 'payments'];
                    if (in_array($first, $adminOnly, true)) {
                        abort(403, 'Akses ditolak.');
                    }

                    return $next($request);
                }
            } catch (\Throwable $e) {
                // fallthrough to deny
            }

            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
