<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // Show payment page which will request a Snap token
    public function show(Booking $booking)
    {
        return view('payment.snap', compact('booking'));
    }

    // Create snap token via Midtrans sandbox API
    public function createToken(Request $request, Booking $booking)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        if (empty($serverKey)) {
            return response()->json(['error' => 'Midtrans server key not configured'], 500);
        }

        $orderId = 'BOOK' . $booking->id . '-' . time();
        $grossAmount = (int) round($booking->total_price ?? 0);

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name ?? 'Customer',
                'email' => $booking->user->email ?? null,
            ],
        ];

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->accept('application/json')
                ->timeout(10)
                ->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $payload);

            $status = $response->status();
            $body = $response->body();

            if (! $response->successful()) {
                // Return detailed error for debugging in dev environment
                return response()->json([
                    'error' => 'Failed to create snap token',
                    'status' => $status,
                    'body' => $body,
                ], 500);
            }

            $data = $response->json();
            return response()->json(['token' => $data['token'] ?? null, 'redirect_url' => $data['redirect_url'] ?? null]);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Exception when creating snap token', 'message' => $e->getMessage()], 500);
        }
    }

    // Mark booking as paid (called from frontend callback)
    public function complete(Request $request, Booking $booking)
    {
        // In real integration validate signature / transaction status from Midtrans
        $booking->payment_status = 'paid';
        $booking->payment_method = 'midtrans_snap';
        $booking->status = 'confirmed';
        $booking->save();

        return response()->json(['success' => true]);
    }
}
