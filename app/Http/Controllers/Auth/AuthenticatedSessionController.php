<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Tangani permintaan autentikasi.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Jika Admin/Staff, arahkan ke panel Filament
        $user = $request->user();
        try {
            if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
                $path = config('filament.path', 'admin');
                return redirect()->intended('/'.trim($path, '/'));
            }
            if ($user && method_exists($user, 'hasRole') && ($user->hasRole('staff') || $user->hasRole('Staff'))) {
                $path = config('filament.path', 'admin');
                return redirect()->intended('/'.trim($path, '/'));
            }
        } catch (\Exception $e) {
            // Abaikan kesalahan, lanjut ke dashboard pengguna
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Hapus sesi autentikasi.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
