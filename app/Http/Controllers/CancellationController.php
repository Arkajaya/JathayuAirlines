<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cancellation;
use Illuminate\Http\Request;

class CancellationController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Load user's bookings to allow initiating cancellation per booking
        $bookings = Booking::with('service', 'cancellation')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        $cancellations = Cancellation::where('user_id', $userId)->orderByDesc('created_at')->get();

        return view('cancellation.index', compact('bookings', 'cancellations'));
    }

    public function create(Booking $booking)
    {
        return view('cancellation.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'reason' => 'required|string|max:2000',
            'refund_method' => 'nullable|string|in:balance,bank',
        ]);

        // Prevent duplicate submission for the same booking
        if ($booking->cancellation) {
            return redirect()->route('cancellations.index')->with('error', 'Sudah terdapat pengajuan pembatalan untuk booking ini.');
        }

        $cancellation = Cancellation::create([
            'booking_id' => $booking->id,
            'user_id' => auth()->id(),
            'reason' => $data['reason'],
            'refund_amount' => null,
            'admin_note' => null,
            'refund_method' => $data['refund_method'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('cancellations.index')->with('success', 'Pengajuan pembatalan berhasil dikirim. Tim kami akan meninjau dan menghubungi Anda.');
    }
}