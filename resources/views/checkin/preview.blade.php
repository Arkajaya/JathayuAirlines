@extends('layouts.app')

@section('title', 'Konfirmasi Check-in')

@section('content')
<div class="container mx-auto py-8 max-w-3xl px-4">
    <h1 class="text-2xl font-semibold mb-4">Konfirmasi Check-in</h1>

    <div class="bg-white shadow-sm rounded p-6 mb-6">
        <h2 class="text-lg font-medium">Rincian Booking</h2>
        <div class="mt-3 text-sm text-gray-700">
            <div>Kode Booking: <strong>{{ $booking->booking_code }}</strong></div>
            <div>Layanan: <strong>{{ $booking->service->name ?? '-' }}</strong></div>
            <div>Keberangkatan: <strong>{{ optional($booking->service->departure_time)->format('d M Y H:i') }}</strong></div>
            <div>Jumlah Penumpang: <strong>{{ $booking->passenger_count }}</strong></div>
        </div>
    </div>

    <form action="{{ route('checkin.confirm') }}" method="POST" class="bg-white shadow-sm rounded p-6">
        @csrf
        <input type="hidden" name="booking_code" value="{{ $booking->booking_code }}">

        <h3 class="text-md font-medium mb-3">Pilih Penumpang untuk Check-in</h3>

        <div class="space-y-3">
            @php $passengers = is_array($booking->passenger_details) ? $booking->passenger_details : json_decode($booking->passenger_details ?? '[]', true); @endphp
            @if(empty($passengers))
                <div class="p-4 bg-yellow-50 border border-yellow-100 rounded text-sm text-yellow-800">Data penumpang tidak tersedia untuk booking ini. Jika ini kesalahan, hubungi customer service.</div>
            @else
                @foreach($passengers as $i => $p)
                    <label class="flex items-center p-3 border rounded">
                        <input type="radio" name="passenger_index" value="{{ $i }}" {{ $i === 0 ? 'checked' : '' }} class="mr-3">
                        <div>
                            <div class="font-medium">{{ $p['name'] ?? '—' }}</div>
                            <div class="text-sm text-gray-600">{{ $p['birth_date'] ?? '' }} {{ isset($p['passport']) ? '• Passport: ' . $p['passport'] : '' }}</div>
                        </div>
                    </label>
                @endforeach
            @endif
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('checkin.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Konfirmasi Check-in</button>
        </div>
    </form>
</div>
@endsection
