<?php

namespace App\Observers;

use App\Models\Booking;
use App\Services\ActivityLogger;

class BookingObserver
{
    public function created(Booking $booking)
    {
        ActivityLogger::log($booking->user_id, 'booking.created', 'Booking created: ' . ($booking->booking_code ?? $booking->id), [
            'booking_id' => $booking->id,
            'service_id' => $booking->service_id,
            'total_price' => $booking->total_price,
        ]);
    }

    public function updated(Booking $booking)
    {
        // log status changes (e.g., cancelled, paid)
        ActivityLogger::log($booking->user_id, 'booking.updated', 'Booking updated: ' . ($booking->booking_code ?? $booking->id), [
            'booking_id' => $booking->id,
            'changes' => $booking->getChanges(),
        ]);
    }
}
