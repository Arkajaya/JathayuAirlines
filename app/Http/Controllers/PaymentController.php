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
        $serverKey = trim((string) env('MIDTRANS_SERVER_KEY', ''));
        if (empty($serverKey)) {
            return response()->json(['error' => 'Midtrans server key not configured'], 500);
        }

        $orderId = 'BOOK' . $booking->id . '-' . time();
        $grossAmount = (int) round($booking->total_price ?? 0);
        if ($grossAmount <= 0) {
            return response()->json(['error' => 'Invalid amount for payment'], 400);
        }

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
            $base = env('MIDTRANS_PRODUCTION', false) ? 'https://app.midtrans.com' : 'https://app.sandbox.midtrans.com';
            $url = $base . '/snap/v1/transactions';

            $response = Http::withBasicAuth($serverKey, '')
                ->accept('application/json')
                ->timeout(15)
                ->post($url, $payload);

            $status = $response->status();
            $body = $response->body();

            if (! $response->successful()) {
                \Log::warning('Midtrans snap create failed', ['status' => $status, 'body' => $body, 'booking_id' => $booking->id]);
                return response()->json([
                    'error' => 'Failed to create snap token',
                    'status' => $status,
                    'body' => $body,
                ], 500);
            }

            $data = $response->json();
            return response()->json(['token' => $data['token'] ?? null, 'redirect_url' => $data['redirect_url'] ?? null]);
        } catch (\Throwable $e) {
            \Log::error('Exception when creating Midtrans snap token', ['exception' => $e->getMessage(), 'booking_id' => $booking->id]);
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
