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
            'passenger_name' => 'required|string',
        ]);

        $booking = Booking::where('booking_code', $request->booking_code)
            ->where('user_id', Auth::id())
            ->first();

        if (!$booking) {
            return back()->with('error', 'Kode booking tidak ditemukan atau Anda tidak memiliki akses.');
        }

        if ($booking->is_checkin) {
            return back()->with('error', 'Check-in sudah dilakukan sebelumnya.');
        }

        // Verifikasi nama penumpang
        $passengerExists = collect($booking->passenger_details)
            ->contains(function ($passenger) use ($request) {
                return strtolower($passenger['name']) === strtolower($request->passenger_name);
            });

        if (!$passengerExists) {
            return back()->with('error', 'Nama penumpang tidak sesuai dengan booking.');
        }

        $booking->update(['is_checkin' => true]);

        return view('checkin.success', compact('booking'))
            ->with('success', 'Check-in berhasil! Silakan download boarding pass Anda.');
    }
}