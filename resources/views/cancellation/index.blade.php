@extends('layouts.app')

@section('title', 'Pengajuan Pembatalan')

@section('content')
<div class="container mx-auto py-10 max-w-6xl px-4">
    <h1 class="text-2xl font-bold tracking-wide uppercase">Pengajuan Pembatalan</h1>
    <a href="{{ route('home') }}" class=" my-8 inline-flex items-center text-sm text-gray-600 hover:text-primary">
        <i class="fas fa-arrow-left mr-2"></i> <span class="hover:underline hover:underline-offset-2">Kembali ke beranda</span>
    </a>

    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-800">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div>
            <h2 class="text-lg font-medium mb-3">Bookings Anda</h2>
            @if($bookings->isEmpty())
                <div class="p-6 bg-white rounded-lg shadow-sm text-center text-sm text-gray-600">Belum ada booking.</div>
            @else
                <div class="space-y-4">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden flex items-center justify-between p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-100 to-cyan-50 rounded flex items-center justify-center">
                                    <i class="fas fa-plane text-indigo-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Kode: <span class="font-medium">{{ $booking->booking_code }}</span></div>
                                    <div class="text-sm text-gray-600">{{ $booking->service->departure_city ?? '-' }} → {{ $booking->service->arrival_city ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ optional($booking->created_at)->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($booking->cancellation)
                                    @php $st = $booking->cancellation->status; @endphp
                                    <span class="inline-block px-3 py-1 rounded text-sm {{ $st=='pending' ? 'bg-yellow-100 text-yellow-800' : ($st=='approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($st) }}</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="inline-block px-3 py-1 rounded text-sm bg-gray-100 text-gray-700">Cancelled</span>
                                @else
                                    <a href="{{ route('cancellations.create', $booking) }}" class="inline-block px-4 py-2 bg-orange-500 text-white rounded-md text-sm shadow">Ajukan Pembatalan</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <h2 class="text-lg font-medium mb-3">Pengajuan Anda</h2>
            @if($cancellations->isEmpty())
                <div class="p-6 bg-white rounded-lg shadow-sm text-sm text-gray-600">Anda belum mengajukan pembatalan.</div>
            @else
                <div class="space-y-3">
                    @foreach($cancellations as $cancellation)
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                        <div class="text-sm">Booking: <span class="font-medium">{{ $cancellation->booking->booking_code ?? '-' }}</span></div>
                                        <div class="text-sm text-gray-700 mt-1">Alasan: {{ Str::limit($cancellation->reason, 140) }}</div>
                                        @if($cancellation->admin_note)
                                            <div class="text-sm text-gray-600 mt-1">Catatan Admin: {{ $cancellation->admin_note }}</div>
                                        @endif
                                        @if(!is_null($cancellation->refund_amount))
                                            <div class="text-sm text-gray-700 mt-1">Refund: <span class="font-medium">Rp {{ number_format($cancellation->refund_amount, 0, ',', '.') }}</span></div>
                                        @endif
                                </div>
                                <div class="text-right">
                                    @if($cancellation->status == 'pending')
                                        <span class="inline-block px-3 py-1 rounded text-sm bg-yellow-100 text-yellow-800">pending</span>
                                    @elseif($cancellation->status == 'approved')
                                        @php
                                            $isRefunded = !is_null($cancellation->refund_amount);
                                        @endphp
                                        <span class="inline-block px-3 py-1 rounded text-sm bg-green-100 text-green-800">@if($isRefunded) refunded @else approved @endif</span>
                                    @else
                                        <span class="inline-block px-3 py-1 rounded text-sm bg-red-100 text-red-800">rejected</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 mt-2">Diajukan: {{ optional($cancellation->created_at)->format('d M Y H:i') }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection