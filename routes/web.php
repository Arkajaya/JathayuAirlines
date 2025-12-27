<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\CancellationController;
use App\Http\Controllers\InfographicController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController as UserPasswordController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;

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
// Authentication routes (using controllers)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Password Reset
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

// Confirmable password / update password
Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);
Route::put('/user/password', [UserPasswordController::class, 'update'])->name('password.update');

// Email verification
Route::get('/email/verify', EmailVerificationPromptController::class)->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)->middleware(['signed'])->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('verification.send');

// Dashboard route used by auth controllers
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Atau jika ingin pakai controller:
// Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
// Route::post('/register', [AuthController::class, 'register']);

// ==============================================
// PROTECTED ROUTES (HANYA UNTUK USER LOGIN)
// ==============================================
Route::middleware(['auth'])->group(function () {
    // Booking Routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{service}/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my-bookings');
    
    // Blog Routes
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/{blog:slug}', [BlogController::class, 'show'])->name('blogs.show');
    
    // Check-in Routes
    Route::get('/checkin', [CheckInController::class, 'index'])->name('checkin.index');
    Route::post('/checkin', [CheckInController::class, 'process'])->name('checkin.process');
    Route::post('/checkin/confirm', [CheckInController::class, 'confirm'])->name('checkin.confirm');
    
    // Cancellation Routes
    Route::get('/cancellations', [CancellationController::class, 'index'])->name('cancellations.index');
    Route::get('/cancellations/{booking}/create', [CancellationController::class, 'create'])->name('cancellations.create');
    Route::post('/cancellations/{booking}', [CancellationController::class, 'store'])->name('cancellations.store');
    
    // Infographics / Statistics
    Route::get('/infographics', [StatisticsController::class, 'index'])->name('infographics');

    // Payment (Midtrans Snap sandbox)
    Route::get('/payments/{booking}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{booking}/token', [App\Http\Controllers\PaymentController::class, 'createToken'])->name('payments.token');
    Route::post('/payments/{booking}/complete', [App\Http\Controllers\PaymentController::class, 'complete'])->name('payments.complete');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Admin - Services CRUD
    Route::get('/admin/services', [ServiceController::class, 'index'])->name('admin.services.index');
    Route::get('/admin/services/create', [ServiceController::class, 'create'])->name('admin.services.create');
    Route::post('/admin/services', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::get('/admin/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
    Route::put('/admin/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');

    // Filament compatibility alias: some Filament views expect named routes
    // like `filament.admin.resources.services.index`. Provide aliases that
    // redirect to the equivalent admin routes to avoid RouteNotFoundExceptions.
    Route::get('filament/admin/resources/services', function () {
        return redirect()->route('admin.services.index');
    })->name('filament.admin.resources.services.index');
    
    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});