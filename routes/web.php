<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\CancellationController;
use App\Http\Controllers\InfographicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// ==============================================
// AUTH ROUTES (BAWAAN LARAVEL BREEZE)
// ==============================================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Atau jika ingin pakai controller:
// Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
// Route::post('/register', [AuthController::class, 'register']);

// ==============================================
// PROTECTED ROUTES (HANYA UNTUK USER LOGIN)
// ==============================================
Route::middleware(['auth'])->group(function () {
    // Booking Routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my-bookings');
    
    // Blog Routes
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/{blog:slug}', [BlogController::class, 'show'])->name('blogs.show');
    
    // Check-in Routes
    Route::get('/checkin', [CheckInController::class, 'index'])->name('checkin.index');
    Route::post('/checkin', [CheckInController::class, 'process'])->name('checkin.process');
    
    // Cancellation Routes
    Route::get('/cancellations', [CancellationController::class, 'index'])->name('cancellations.index');
    Route::post('/cancellations/{booking}', [CancellationController::class, 'store'])->name('cancellations.store');
    
    // Infographics
    Route::get('/infographics', [InfographicController::class, 'index'])->name('infographics');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});