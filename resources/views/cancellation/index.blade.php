@extends('layouts.app')

@section('title', 'Pengajuan Pembatalan')

@section('content')
<div class="container mx-auto py-8 max-w-4xl px-4">
    <h1 class="text-2xl font-semibold mb-6">Pengajuan Pembatalan</h1>

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
                <p class="text-sm text-gray-600">Belum ada booking.</p>
            @else
                <div class="space-y-4">
                    @foreach($bookings as $booking)
                        <div class="border rounded p-4 bg-white shadow-sm">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="text-sm text-gray-600">Kode: <span class="font-medium">{{ $booking->booking_code }}</span></div>
                                    <div class="text-sm text-gray-600">Layanan: {{ $booking->service->name ?? '-' }}</div>
                                    <div class="text-sm text-gray-600">Tanggal: {{ optional($booking->created_at)->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-600">Status: <span class="font-medium">{{ ucfirst($booking->status) }}</span></div>
                                </div>
                                <div class="text-right">
                                    @if($booking->cancellation)
                                        <span class="inline-block px-3 py-1 rounded text-sm {{ $booking->cancellation->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : ($booking->cancellation->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($booking->cancellation->status) }}</span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="inline-block px-3 py-1 rounded text-sm bg-gray-100 text-gray-700">Cancelled</span>
                                    @else
                                        <a href="{{ route('cancellations.create', $booking) }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded text-sm">Ajukan Pembatalan</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <h2 class="text-lg font-medium mb-3">Pengajuan Anda</h2>
            @if($cancellations->isEmpty())
                <p class="text-sm text-gray-600">Anda belum mengajukan pembatalan.</p>
            @else
                <div class="space-y-3">
                    @foreach($cancellations as $cancellation)
                        <div class="border rounded p-3 bg-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm">Booking: <span class="font-medium">{{ $cancellation->booking->booking_code ?? '-' }}</span></div>
                                    <div class="text-sm text-gray-700 mt-1">Alasan: {{ Str::limit($cancellation->reason, 120) }}</div>
                                    @if($cancellation->admin_note)
                                        <div class="text-sm text-gray-600 mt-1">Catatan Admin: {{ $cancellation->admin_note }}</div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    @if($cancellation->status == 'pending')
                                        <span class="inline-block px-3 py-1 rounded text-sm bg-yellow-100 text-yellow-800">Menunggu</span>
                                    @elseif($cancellation->status == 'approved')
                                        <span class="inline-block px-3 py-1 rounded text-sm bg-green-100 text-green-800">Disetujui</span>
                                    @else
                                        <span class="inline-block px-3 py-1 rounded text-sm bg-red-100 text-red-800">Ditolak</span>
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