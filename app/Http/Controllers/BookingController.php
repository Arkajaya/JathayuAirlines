<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $flights = Service::where('is_active', true)
            ->where('departure_time', '>', now())
            ->orderBy('departure_time', 'asc')
            ->get();

        return view('bookings.index', compact('flights'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'passenger_count' => 'required|integer|min:1|max:10',
            'passenger_details' => 'required|array',
            'passenger_details.*.name' => 'required|string',
            'passenger_details.*.birth_date' => 'required|date',
            'passenger_details.*.passport' => 'nullable|string',
            'special_request' => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($request->service_id);

        if ($service->available_seats < $request->passenger_count) {
            return back()->with('error', 'Kursi tidak tersedia untuk jumlah penumpang ini.');
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $service->id,
            'passenger_count' => $request->passenger_count,
            'passenger_details' => $request->passenger_details,
            'total_price' => $service->price * $request->passenger_count,
            'status' => 'pending',
            'special_request' => $request->special_request,
        ]);

        // Update booked seats
        $service->increment('booked_seats', $request->passenger_count);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Pemesanan berhasil! Kode booking: ' . $booking->booking_code);
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('bookings.show', compact('booking'));
    }

    public function myBookings()
    {
        $bookings = Auth::user()->bookings()
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.my-bookings', compact('bookings'));
    }
}