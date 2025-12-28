<?php

namespace App\Observers;

use App\Models\Cancellation;
use App\Services\ActivityLogger;
use App\Models\Booking;

class CancellationObserver
{
    public function created(Cancellation $cancellation)
    {
        ActivityLogger::log($cancellation->user_id, 'cancellation.created', 'Cancellation requested for booking ' . $cancellation->booking_id, [
            'cancellation_id' => $cancellation->id,
            'booking_id' => $cancellation->booking_id,
        ]);
    }

    public function updated(Cancellation $cancellation)
    {
        if ($cancellation->wasChanged('status') && $cancellation->status === 'approved') {
            $booking = $cancellation->booking;
            if (! $booking) {
                return;
            }

            $refundAmount = $cancellation->refund_amount ?? ($booking->total_price ?? 0);

            // Mark booking as cancelled regardless of payment state
            $booking->status = 'cancelled';

            // If booking had seats assigned, free them so they become available again
            try {
                if (! empty($booking->seats) && is_array($booking->seats)) {
                    // store previous passenger count for adjustment
                    $prevCount = $booking->passenger_count ?? count($booking->seats);
                    $booking->seats = null;
                    $booking->passenger_count = 0;
                } else {
                    $prevCount = $booking->passenger_count ?? 0;
                }

                // adjust service booked_seats safely
                $service = $booking->service;
                if ($service && $prevCount) {
                    $new = max(0, ($service->booked_seats ?? 0) - $prevCount);
                    $service->booked_seats = $new;
                    $service->save();
                }
            } catch (\Throwable $e) {
                // ignore seat release errors
            }

            // If booking was paid, set refund amount (if not set), mark payment_status as refunded and log refund
            if (($booking->payment_status ?? 'pending') === 'paid') {
                if (is_null($cancellation->refund_amount)) {
                    $cancellation->refund_amount = $refundAmount;
                    $cancellation->save();
                }

                $booking->payment_status = 'refunded';
                ActivityLogger::log($cancellation->user_id, 'cancellation.refunded', 'Refund processed for booking ' . ($booking->booking_code ?? $booking->id), [
                    'cancellation_id' => $cancellation->id,
                    'booking_id' => $booking->id,
                    'refund_amount' => $cancellation->refund_amount,
                ]);
            }

            $booking->save();
        }
    }
}
