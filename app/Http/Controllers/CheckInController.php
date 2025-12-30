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

        // Find booking by code. Allow lookup by code even if guest (no login).
        $booking = Booking::where('booking_code', $request->booking_code)->first();

        if (!$booking) {
            return back()->with('error', 'Kode booking tidak ditemukan.');
        }

        // If user is logged in, ensure they own the booking (unless admin)
        if (Auth::check() && $booking->user_id && $booking->user_id !== Auth::id()) {
            if (! Auth::user()->isAdmin()) {
                return back()->with('error', 'Anda tidak memiliki akses untuk booking ini.');
            }
        }

        if ($booking->is_checkin) {
            return back()->with('error', 'Check-in sudah dilakukan sebelumnya.');
        }

        // Prevent check-in for unpaid bookings (admins may override)
        if (($booking->payment_status ?? null) !== 'paid') {
            if (! (Auth::check() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())) {
                return back()->with('error', 'Check-in hanya diperbolehkan untuk booking yang sudah dibayar.');
            }
        }

        // Show preview page (single passenger flow)
        return view('checkin.preview', compact('booking'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|string',
        ]);

        $booking = Booking::where('booking_code', $request->booking_code)->first();
        if (! $booking) {
            return back()->with('error', 'Booking tidak ditemukan.');
        }

        if ($booking->is_checkin) {
            return redirect()->route('checkin.index')->with('error', 'Check-in sudah dilakukan untuk booking ini.');
        }

            // Prevent confirming check-in for unpaid bookings (admins may override)
            if (($booking->payment_status ?? null) !== 'paid') {
                if (! (Auth::check() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())) {
                    return back()->with('error', 'Tidak dapat melakukan konfirmasi check-in: pembayaran belum lengkap.');
                }
            }

        // Allow passenger data override from the preview form (fields named passenger_details[name], etc.)
        $posted = $request->input('passenger_details', null);

        // Normalize stored passenger data: either associative single passenger or array of passengers
        $stored = $booking->passenger_details ?? [];
        if (is_array($stored) && array_keys($stored) === range(0, count($stored) - 1)) {
            // numeric array
            $storedFirst = $stored[0] ?? [];
        } else {
            // associative single passenger
            $storedFirst = is_array($stored) ? $stored : [];
        }

        $passenger = $posted && is_array($posted) ? array_merge($storedFirst, $posted) : $storedFirst;

        if (empty($passenger) || empty(trim((string) ($passenger['name'] ?? '')))) {
            return back()->with('error', 'Data penumpang tidak valid. Silakan lengkapi nama penumpang.');
        }

        // Optionally persist updated passenger data for future reference (update stored passenger_details)
        try {
            // store as numeric array to keep consistency with older code
            $booking->passenger_details = [$passenger];
            $booking->save();
        } catch (\Exception $e) {
            // ignore persistence failure — still allow check-in
        }

        // Mark booking as checked-in.
        $booking->update(['is_checkin' => true]);

        // Optionally store last_checked_in_passenger for audit (not schema-backed here)

        return view('checkin.success', compact('booking'))
            ->with('success', 'Check-in berhasil! Silakan download boarding pass Anda.');
    }

    public function boardingPass(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        if (!$booking->is_checkin) {
            abort(403, 'Boarding pass hanya tersedia setelah check-in.');
        }

        // prefer PDF generation if dompdf available
        $filename = 'boardingpass-' . $booking->booking_code . '.pdf';
        if (class_exists(\Barryvdh\DomPDF\Facade::class) || app()->bound('dompdf')) {
            try {
                $pdf = \PDF::loadView('checkin.boarding-pass', compact('booking'));
                return $pdf->download($filename);
            } catch (\Exception $e) {
                // fallback to html
            }
        }

        $html = view('checkin.boarding-pass', compact('booking'))->render();
        return response()->streamDownload(function () use ($html) { echo $html; }, 'boardingpass-' . $booking->booking_code . '.html', ['Content-Type' => 'text/html; charset=utf-8']);
    }
}