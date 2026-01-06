<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Arahkan pengguna Admin/Staff ke panel Filament
 */
class RedirectAdminToFilament
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()){
            $user = auth()->user();
            try {
                if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
                    $path = config('filament.path', 'admin');
                    return redirect()->to('/'.trim($path, '/'));
                }
                // Also redirect staff to Filament
                if (method_exists($user, 'hasRole') && ($user->hasRole('Staff') || $user->hasRole('staff'))) {
                    $path = config('filament.path', 'admin');
                    return redirect()->to('/'.trim($path, '/'));
                }
            } catch (\Exception $e) {
                // Abaikan jika ada error peran
            }
        }
        return $next($request);
    }
}
