<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckInController extends Controller
{
    public function index()
    {
        return view('checkin.index');
    }

    public function process(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|string',
        ]);

        // Find booking and ensure user owns it (or allow guest access if owner not logged)
        $booking = Booking::where('booking_code', $request->booking_code)
            ->where('user_id', Auth::id())
            ->first();

        if (!$booking) {
            return back()->with('error', 'Kode booking tidak ditemukan atau Anda tidak memiliki akses.');
        }

        if ($booking->is_checkin) {
            return back()->with('error', 'Check-in sudah dilakukan sebelumnya.');
        }

        // Show preview page where user selects passenger
        return view('checkin.preview', compact('booking'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|string',
            'passenger_index' => 'required|integer|min:0',
        ]);

        $booking = Booking::where('booking_code', $request->booking_code)
            ->where('user_id', Auth::id())
            ->first();

        if (!$booking) {
            return back()->with('error', 'Booking tidak ditemukan atau Anda tidak memiliki akses.');
        }

        if ($booking->is_checkin) {
            return redirect()->route('checkin.index')->with('error', 'Check-in sudah dilakukan untuk booking ini.');
        }

        $passengers = $booking->passenger_details ?? [];
        $idx = (int) $request->passenger_index;

        if (!isset($passengers[$idx]) || empty($passengers[$idx]['name'])) {
            return back()->with('error', 'Pilihan penumpang tidak valid.');
        }

        // Mark booking as checked-in. In a real app we may track which passenger checked-in.
        $booking->update(['is_checkin' => true]);

        // Optionally store last_checked_in_passenger for audit (not schema-backed here)

        return view('checkin.success', compact('booking'))
            ->with('success', 'Check-in berhasil! Silakan download boarding pass Anda.');
    }
}