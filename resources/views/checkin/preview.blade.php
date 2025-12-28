@extends('layouts.app')

@section('title', 'Konfirmasi Check-in')

@section('content')
<div class="container mx-auto py-8 max-w-3xl px-4">
    <h1 class="text-2xl font-semibold mb-4">Konfirmasi Check-in</h1>

    <div class="bg-white shadow-sm rounded p-6 mb-6">
        <h2 class="text-lg font-medium">Rincian Booking</h2>
        <div class="mt-3 text-sm text-gray-700">
            <div>Kode Booking: <strong>{{ $booking->booking_code }}</strong></div>
            <div>Layanan: <strong>{{ $booking->service->airline_name ?? $booking->service->flight_number ?? '-' }}</strong></div>
            <div>Keberangkatan: <strong>{{ optional($booking->service->departure_time)->format('d M Y H:i') }}</strong></div>
            <div>Jumlah Penumpang: <strong>{{ $booking->passenger_count }}</strong></div>
        </div>
    </div>

    <form id="checkin-form" action="{{ route('checkin.confirm') }}" method="POST" class="bg-white shadow-sm rounded p-6">
        @csrf
        <input type="hidden" name="booking_code" value="{{ $booking->booking_code }}">

        <h3 class="text-md font-medium mb-3">Data Penumpang</h3>
        @php
            $stored = $booking->passenger_details ?? [];
            if (is_array($stored) && array_keys($stored) === range(0, count($stored) - 1)) {
                $storedFirst = $stored[0] ?? [];
            } else {
                $storedFirst = is_array($stored) ? $stored : [];
            }
            $p = $storedFirst;
        @endphp

        @if(empty($p) || empty(trim((string)($p['name'] ?? ''))))
            <div class="p-4 bg-yellow-50 border border-yellow-100 rounded text-sm text-yellow-800">Data penumpang tidak tersedia untuk booking ini. Silakan lengkapi data sebelum konfirmasi.</div>
        @endif

        <div class="p-4 border rounded relative">
            <div id="passenger-view">
                <div class="font-medium" id="passenger-name">{{ $p['name'] ?? '—' }}</div>
                <div class="text-sm text-gray-600" id="passenger-meta">{{ $p['birth_date'] ?? '' }} {{ isset($p['passport']) ? '• Passport: ' . $p['passport'] : '' }}</div>
            </div>

            <button type="button" id="edit-passenger" class="absolute top-3 right-3 text-sm text-indigo-600 hover:underline">Edit</button>

            <div id="passenger-edit" class="mt-3 hidden">
                <label class="block text-sm text-gray-700">Nama</label>
                <input type="text" name="passenger_details[name]" form="checkin-form" value="{{ $p['name'] ?? '' }}" class="w-full border rounded px-3 py-2 mb-2">
                <label class="block text-sm text-gray-700">Tanggal Lahir</label>
                <input type="date" name="passenger_details[birth_date]" form="checkin-form" value="{{ $p['birth_date'] ?? '' }}" class="w-full border rounded px-3 py-2 mb-2">
                <label class="block text-sm text-gray-700">No. Passport (opsional)</label>
                <input type="text" name="passenger_details[passport]" form="checkin-form" value="{{ $p['passport'] ?? '' }}" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('checkin.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
            <button type="submit" id="confirm-btn" form="checkin-form" class="px-4 py-2 bg-indigo-600 text-white rounded">Konfirmasi Check-in</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const editBtn = document.getElementById('edit-passenger');
            const editBox = document.getElementById('passenger-edit');
            const viewBox = document.getElementById('passenger-view');
            if(editBtn){
                editBtn.addEventListener('click', function(){
                    editBox.classList.toggle('hidden');
                    viewBox.classList.toggle('hidden');
                });
            }
        });
    </script>
</div>
@endsection
