<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cancellation;
use Illuminate\Http\Request;

class CancellationController extends Controller
{
    public function index()
    {
        $cancellations = Cancellation::where('user_id', auth()->id())->get();
        return view('cancellation.index', compact('cancellations'));
    }

    public function create(Booking $booking)
    {
        return view('cancellation.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        $request->validate([
            'reason' => 'required',
        ]);

        Cancellation::create([
            'booking_id' => $booking->id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Ubah status booking menjadi cancelled? Atau tunggu persetujuan?
        // Kita bisa ubah setelah persetujuan admin. Jadi sementara biarkan pending.

        return redirect()->route('cancellation.index')->with('success', 'Pengajuan pembatalan berhasil.');
    }
}