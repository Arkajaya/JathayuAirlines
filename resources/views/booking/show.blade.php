@extends('layouts.app')

@section('title', 'Booking Detail')

@section('content')
<div class="container mx-auto py-8 max-w-3xl px-4">
    <h1 class="text-2xl font-bold mb-4">Detail Booking</h1>

    <div class="bg-white shadow-sm rounded p-6">
        @if(request()->query('paid'))
            <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800">Pembayaran berhasil. Terima kasih.</div>
        @endif
        <div class="mb-3">
            <div class="text-sm text-gray-600">Kode Booking</div>
            <div class="text-lg font-medium">{{ $booking->booking_code }}</div>
        </div>

        <div class="mb-3">
            <div class="text-sm text-gray-600">Layanan</div>
            <div class="font-medium">{{ $booking->service->name ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <div class="text-sm text-gray-600">Total Harga</div>
            <div class="text-lg font-semibold">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</div>
        </div>

        <div class="mb-3">
            <div class="text-sm text-gray-600">Status Booking</div>
            <div class="font-medium">{{ ucfirst($booking->status) }}</div>
        </div>

        <div class="mb-3">
            <div class="text-sm text-gray-600">Status Pembayaran</div>
            <div class="font-medium">{{ $booking->payment_status ?? 'unpaid' }}</div>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <a href="{{ route('bookings.index') }}" class="text-sm text-gray-600 hover:underline">Kembali ke daftar</a>
            <div>
                @if(($booking->payment_status ?? 'unpaid') !== 'paid' && $booking->status !== 'cancelled')
                    <a href="{{ route('payments.show', $booking) }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded">Bayar</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
