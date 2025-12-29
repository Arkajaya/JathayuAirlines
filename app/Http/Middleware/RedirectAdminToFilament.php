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
                // Cek peran staff/admin (Spatie)
                if (method_exists($user, 'hasRole') && ($user->hasRole('staff') || $user->hasRole('Staff') || $user->hasRole('Admin'))) {
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
