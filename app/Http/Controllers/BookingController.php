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
        $query = Service::query()->where('is_active', true)->where('departure_time', '>', now());

        // filters from search form
        $from = request('from');
        $to = request('to');
        $date = request('date');
        $passengers = request('passengers');
        $flightId = request('flight');

        if ($from) {
            $query->where('departure_city', 'like', "%{$from}%");
        }
        if ($to) {
            $query->where('arrival_city', 'like', "%{$to}%");
        }
        if ($date) {
            $query->whereDate('departure_time', $date);
        }
        if ($flightId) {
            $query->where('id', $flightId);
        }

        $flights = $query->orderBy('departure_time', 'asc')->get();

        return view('booking.index', compact('flights'));
    }

    public function create(Service $service)
    {
        // Show a focused booking form for the chosen service
        return view('booking.create', ['service' => $service]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'passenger_count' => 'required|integer|min:1',
            'special_request' => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($request->service_id);

        if ($service->available_seats < $request->passenger_count) {
            return back()->with('error', 'Kursi tidak tersedia untuk jumlah penumpang ini.');
        }

        $passengerDetails = $request->input('passenger_details', []);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $service->id,
            'passenger_count' => $request->passenger_count,
            'passenger_details' => $passengerDetails,
            'total_price' => $service->price * $request->passenger_count,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => null,
            'special_request' => $request->special_request,
        ]);

        // Update booked seats
        $service->increment('booked_seats', $request->passenger_count);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Pemesanan berhasil! Kode booking: ' . $booking->booking_code . '. Silakan lakukan pembayaran untuk mengonfirmasi booking.');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('booking.show', compact('booking'));
    }

    public function myBookings()
    {
        $bookings = Auth::user()->bookings()
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.my-bookings', compact('bookings'));
    }
}