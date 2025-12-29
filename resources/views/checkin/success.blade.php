@extends('layouts.app')

@section('title', 'Check-in Berhasil')

@section('content')
<div class="container mx-auto py-12 min-h-[40vh] px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <div class="flex items-center justify-center">
                <div class="w-14 h-14 rounded-full bg-green-50 flex items-center justify-center mr-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div class="text-left">
                    <h1 class="text-2xl font-bold">Check-in Berhasil</h1>
                    <div class="text-sm text-gray-600">Booking <span class="font-mono">{{ $booking->booking_code }}</span> telah berhasil</div>
                </div>
            </div>

            @if(session('success'))
                <div class="mt-4 mb-2 p-3 rounded bg-green-50 border border-green-200 text-green-800">{{ session('success') }}</div>
            @endif

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                <a href="{{ route('bookings.show', $booking) }}" class="inline-flex items-center justify-center px-4 py-2 border rounded-md text-sm hover:bg-gray-50">Lihat Detail Booking</a>
                <a href="{{ route('checkin.boarding-pass', $booking) }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Download Boarding Pass</a>
            </div>

            <div class="mt-6 text-left">
                <div class="border rounded-lg p-3 bg-slate-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-500">Nama</div>
                            <div class="font-medium">{{ $booking->user->name ?? ($booking->passenger_details[0]['name'] ?? '-')}}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Kursi</div>
                            <div class="font-medium">{{ !empty($booking->seats) ? implode(', ', $booking->seats) : '-' }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Boarding</div>
                            <div class="font-medium">{{ optional($booking->service->departure_time)->subMinutes(30)->format('H:i') ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
