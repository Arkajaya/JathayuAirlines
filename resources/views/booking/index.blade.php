@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="ml-20 pt-16 text-3xl font-bold">Penerbangan / Layanan</h2>
    <div class="px-16 py-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($flights as $flight)
        <div class="border-l-4 border-primary hover:shadow-lg hover:-translate-x-1 hover:-translate-y-1 transition-all duration-500 bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-bold mb-2">{{ $flight->departure_city }} → {{ $flight->arrival_city }}</h3>
            <p class="text-sm text-gray-600 mb-2">Keberangkatan: {{ $flight->departure_time->format('d M Y H:i') }}</p>
            <p class="text-sm text-gray-600 mb-2">Kedatangan: {{ $flight->arrival_time->format('d M Y H:i') }}</p>
            <p class="text-sm text-gray-600 mb-2">Kursi tersedia: {{ $flight->available_seats }}</p>
            <p class="text-xl font-bold text-primary mb-4">Rp {{ number_format($flight->price, 0, ',', '.') }}</p>

            <div class="mt-4 flex items-center justify-between">
                <a href="{{ route('bookings.create', $flight) }}" class="bg-primary text-white px-4 py-2 rounded">Pesan Sekarang</a>
                <div class="text-sm text-gray-600">Harga: <span class="font-semibold">Rp {{ number_format($flight->price,0,',','.') }}</span></div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection