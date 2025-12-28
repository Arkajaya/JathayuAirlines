@extends('layouts.app')

@section('content')
<div class="container w-full mx-auto py-8 br">
    <h2 class="ml-20 pt-8 font tracking-wider text-3xl font-bold uppercase">Penerbangan / Layanan</h2>
    <a href="{{ route('home') }}" class="ml-20 mt-2 inline-flex items-center text-sm text-gray-600 hover:text-primary">
        <i class="fas fa-arrow-left mr-2"></i> <span class="hover:underline hover:underline-offset-2">Kembali ke beranda</span>
    </a>
    <div class="px-16 py-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 flex-wrap justify-center ">
        @foreach($flights as $flight)
        <div class="border-l-4 border-l-sky-400 bg-white rounded-lg shadow p-4 w-[23rem] hover:shadow-lg transition-transform transform hover:-translate-y-1">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-sm text-gray-500">{{ $flight->airline_name ?? 'Maskapai' }}</div>
                    <h3 class="text-lg font-bold">{{ $flight->departure_city }} → {{ $flight->arrival_city }}</h3>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600">{{ $flight->flight_number }}</div>
                    <div class="mt-1 inline-block px-2 py-1 text-xs rounded bg-gray-100">{{ $flight->class ?? 'Economy' }}</div>
                </div>
            </div>

            <div class="mt-3 text-sm text-gray-600">
                <div>Keberangkatan: {{ $flight->departure_time->format('d M Y H:i') }}</div>
                <div>Kedatangan: {{ $flight->arrival_time->format('d M Y H:i') }}</div>
                <div class="mt-2">Kursi tersedia: <span class="font-semibold">{{ $flight->available_seats }}</span></div>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <a href="{{ route('bookings.create', $flight) }}" class="bg-primary text-white px-4 py-2 rounded">Pesan</a>
                <div class="text-xl font-bold text-primary">Rp {{ number_format($flight->price, 0, ',', '.') }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection