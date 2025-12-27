@extends('layouts.app')

@section('title', 'Pesan Tiket')

@section('content')
<div class="container mx-auto py-8 max-w-2xl px-4">
    <h1 class="text-2xl font-semibold mb-6">Pesan Tiket - {{ $service->departure_city }} → {{ $service->arrival_city }}</h1>

    <div class="bg-white shadow-sm rounded p-6">
        <div class="mb-4">
            <div class="text-sm text-gray-600">Kode Penerbangan</div>
            <div class="text-lg font-medium">{{ $service->flight_number }}</div>
        </div>

        <div class="mb-4">
            <div class="text-sm text-gray-600">Keberangkatan</div>
            <div class="font-medium">{{ $service->departure_time->format('d M Y H:i') }} - {{ $service->departure_city }}</div>
        </div>

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Jumlah Penumpang</label>
                @php
                    $available = $service->available_seats ?? 0;
                    $max = min(5, $available);
                @endphp

                @if($available <= 0)
                    <div class="mt-2 text-red-600">Maaf, tidak ada kursi tersedia untuk penerbangan ini.</div>
                @else
                    <div class="mt-2 flex items-center space-x-3">
                        @for($i = 1; $i <= $max; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="passenger_count" value="{{ $i }}" {{ $i === 1 ? 'checked' : '' }} class="sr-only peer">
                                <div class="px-3 py-2 border rounded-md text-sm peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary transition-colors">
                                    {{ $i }}
                                </div>
                            </label>
                        @endfor
                    </div>
                @endif
            </div>

            <div class="mb-4">
                <label for="special_request" class="block text-sm font-medium text-gray-700">Catatan (opsional)</label>
                <textarea id="special_request" name="special_request" rows="3" class="mt-1 block w-full border rounded p-2">{{ old('special_request') }}</textarea>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('bookings.index') }}" class="text-sm text-gray-600 hover:underline">Kembali ke daftar</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded" @if($available <= 0) disabled class="opacity-50 cursor-not-allowed" @endif>Pesan & Lanjut Pembayaran</button>
            </div>
        </form>
    </div>
</div>
@endsection
