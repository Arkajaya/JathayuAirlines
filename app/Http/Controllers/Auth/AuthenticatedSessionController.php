<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
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
        // Pastikan tidak terlalu banyak percobaan
        $request->ensureIsNotRateLimited();

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if ($user) {
            // Jika user ada tapi password salah, berikan pesan yang sesuai
            if (! Hash::check($password, $user->password)) {
                RateLimiter::hit($request->throttleKey());
                throw ValidationException::withMessages([
                    'password' => 'Password salah.',
                ]);
            }
        }

        // Jika tidak ada user atau password cocok, coba autentikasi menggunakan mekanisme Laravel
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($request->throttleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

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
