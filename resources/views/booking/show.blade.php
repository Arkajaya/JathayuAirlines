@extends('layouts.app')

@section('title', 'Booking Detail')

@section('content')
<div class="container mx-auto py-8 max-w-4xl px-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Detail Booking</h1>
        <a href="{{ route('bookings.index') }}" class="text-sm text-gray-600 hover:underline">Kembali ke daftar penerbangan</a>
    </div>

    <div class="bg-white shadow-sm rounded p-6">
        @if(request()->query('paid'))
            <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800">Pembayaran berhasil. Terima kasih.</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="mb-4">
                    <div class="text-sm text-gray-600">Kode Booking</div>
                    <div class="text-lg font-medium">{{ $booking->booking_code }}</div>
                </div>

                <div class="mb-4">
                    <div class="text-sm text-gray-600">Rute</div>
                    <div class="font-medium">{{ $booking->service->departure_city ?? '-' }} → {{ $booking->service->arrival_city ?? '-' }}</div>
                    <div class="text-sm text-gray-500">{{ $booking->service->flight_number ?? '' }} • {{ $booking->service->departure_time->format('d M Y H:i') ?? '' }}</div>
                </div>

                @if(!empty($booking->seats))
                    <div class="mb-4">
                        <div class="text-sm text-gray-600">Kursi</div>
                        <div class="font-medium">{{ implode(', ', $booking->seats) }}</div>
                    </div>
                @endif

                @if(!empty($booking->special_request))
                    <div class="mb-4">
                        <div class="text-sm text-gray-600">Catatan</div>
                        <div class="text-sm text-gray-700">{{ $booking->special_request }}</div>
                    </div>
                @endif
            </div>

            <div class="md:col-span-1">
                <div class="p-4 border rounded">
                    <div class="text-sm text-gray-600">Total Harga</div>
                    <div class="text-2xl font-bold text-primary mb-3">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</div>

                    <div class="mb-2">
                        <div class="text-sm text-gray-600">Status Booking</div>
                        <div class="inline-block mt-1 px-2 py-1 rounded text-sm {{ $booking->status == 'confirmed' ? 'bg-green-50 text-green-700' : ($booking->status == 'cancelled' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700') }}">{{ ucfirst($booking->status) }}</div>
                    </div>

                    <div class="mb-4">
                        <div class="text-sm text-gray-600">Status Pembayaran</div>
                        <div class="inline-block mt-1 px-2 py-1 rounded text-sm {{ ($booking->payment_status ?? 'unpaid') === 'paid' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">{{ $booking->payment_status ?? 'unpaid' }}</div>
                    </div>

                    <div class="flex items-center">
                        @if(($booking->payment_status ?? 'unpaid') !== 'paid' && $booking->status !== 'cancelled')
                            <a href="{{ route('payments.show', $booking) }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded">Bayar</a>
                        @endif
                        @if(($booking->payment_status ?? 'unpaid') === 'paid')
                            <a href="{{ route('bookings.invoice', $booking) }}" class="inline-block ml-2 px-4 py-2 border border-gray-300 rounded text-sm">Download Invoice</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
