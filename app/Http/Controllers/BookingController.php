<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // Only fall back to showing all active services when the user did not
        // apply any search filters. If filters were applied but no flights
        // match, return an empty collection so the UI can show "no results".
        $hasFilters = (bool) ($from || $to || $date || $flightId || $passengers);
        if ($flights->isEmpty() && ! $hasFilters) {
            $flights = Service::where('is_active', true)
                ->orderBy('departure_time', 'asc')
                ->get();
        }

        return view('booking.index', compact('flights'));
    }

    public function create(Service $service)
    {
        // Show a focused booking form for the chosen service
        // collect already occupied seats for this service
        $occupiedArrays = Booking::where('service_id', $service->id)
            ->whereNotNull('seats')
            ->pluck('seats')
            ->toArray();

        $occupiedSeats = [];
        foreach ($occupiedArrays as $arr) {
            if (is_array($arr)) {
                $occupiedSeats = array_merge($occupiedSeats, $arr);
            }
        }

        // available classes (fall back to service->class if provided)
        return view('booking.create', ['service' => $service, 'occupiedSeats' => $occupiedSeats]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'special_request' => 'nullable|string|max:500',
            'seats' => 'nullable|array',
            'seats.*' => 'string',
        ]);

        $service = Service::findOrFail($request->service_id);

        // enforce single-passenger booking
        $passengerCount = 1;
        if ($service->available_seats < $passengerCount) {
            return back()->with('error', 'Kursi tidak tersedia.');
        }

        $passengerDetails = $request->input('passenger_details', []);

        $selectedSeats = $request->input('seats', []);

        // If service defines a seatmap (capacity), require seat selection
        $requiresSeatSelection = ($service->capacity ?? 0) > 0;

        if ($requiresSeatSelection && empty($selectedSeats)) {
            return back()->with('error', 'Silakan pilih kursi sebelum melanjutkan.')->withInput();
        }

        // validate seats selection vs existing bookings
        if (!empty($selectedSeats)) {
            if (count($selectedSeats) !== $passengerCount) {
                return back()->with('error', 'Jumlah kursi yang dipilih harus sama dengan jumlah penumpang.')->withInput();
            }

            $occupiedArrays = Booking::where('service_id', $service->id)
                ->whereNotNull('seats')
                ->pluck('seats')
                ->toArray();

            $occupiedSeats = [];
            foreach ($occupiedArrays as $arr) {
                if (is_array($arr)) {
                    $occupiedSeats = array_merge($occupiedSeats, $arr);
                }
            }

            if (count(array_intersect($occupiedSeats, $selectedSeats)) > 0) {
                return back()->with('error', 'Beberapa kursi sudah dipesan, silakan pilih kursi lain.')->withInput();
            }
        }

        // Idempotency guard: prevent duplicate rapid submissions creating multiple bookings
        $possibleDuplicate = Booking::where('user_id', Auth::id())
            ->where('service_id', $service->id)
            ->where('passenger_count', $passengerCount)
            ->where('total_price', $service->price * $passengerCount)
            ->where('created_at', '>=', now()->subMinutes(2))
            ->first();

        if ($possibleDuplicate) {
            return redirect()->route('bookings.show', $possibleDuplicate)
                ->with('info', 'Pemesanan mungkin sudah diproses. Jika Anda baru saja mengirim, silakan periksa pesanan Anda.');
        }

        // Create booking in transaction to avoid race conditions
        $booking = DB::transaction(function () use ($service, $passengerCount, $passengerDetails, $selectedSeats, $request) {
            $b = Booking::create([
                'user_id' => Auth::id(),
                'service_id' => $service->id,
                'passenger_count' => $passengerCount,
                'passenger_details' => $passengerDetails,
                'seats' => $selectedSeats,
                'travel_class' => $service->class,
                'total_price' => $service->price * $passengerCount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => null,
                'special_request' => $request->special_request,
            ]);

            // Update booked seats
            $service->increment('booked_seats', $passengerCount);

            return $b;
        });

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

    public function invoice(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        // only allow download if paid
        if (($booking->payment_status ?? 'pending') !== 'paid') {
            abort(403, 'Invoice hanya tersedia untuk booking yang sudah dibayar.');
        }
        // Prefer PDF if dompdf (barryvdh/laravel-dompdf) is installed
        $pdfFilename = 'invoice-' . $booking->booking_code . '.pdf';

        if (class_exists(\Barryvdh\DomPDF\Facade::class) || app()->bound('dompdf')) {
            try {
                $pdf = \PDF::loadView('booking.invoice', compact('booking'));
                return $pdf->download($pdfFilename);
            } catch (\Exception $e) {
                // fallback to html download if PDF generation fails
            }
        }

        $html = view('booking.invoice', compact('booking'))->render();
        $filename = 'invoice-' . $booking->booking_code . '.html';

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, $filename, [
            'Content-Type' => 'text/html; charset=utf-8'
        ]);
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