<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cancellation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $today = now()->format('Y-m-d');
        $todayBookings = Booking::whereDate('created_at', $today)->count();
        $pendingCancellations = Cancellation::where('status', 'pending')->count();
        $revenue = Booking::where('status', 'confirmed')->sum('total_price');

        $bookings = Booking::latest()->take(10)->get();

        return view('admin.dashboard', compact('todayBookings', 'pendingCancellations', 'revenue', 'bookings'));
    }
}