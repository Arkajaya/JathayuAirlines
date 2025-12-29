@extends('layouts.app')

@section('title', 'Destinasi - Jathayu Airlines')

@section('content')
<div class="container mx-auto py-12 px-6">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold tracking-widest">Destinasi Populer</h1>
        <p class="text-gray-600 mt-2 tracking-wider">Jelajahi destinasi terbaik kami. Mari Terbang Bersama <span class="font-bold bg-gradient-to-tr from-sky-400 to-sky-200 bg-clip-text transition-all duration-300 hover:text-black hover:underline underline-offset-2 text-transparent">Jathayu Airlines</span></p>
    </div>
    <a href="{{ route('home') }}" class="ml-20 mb-10 inline-flex items-center text-sm text-gray-600 hover:text-primary">
        <i class="fas fa-arrow-left mr-2"></i> <span class="hover:underline hover:underline-offset-2">Kembali ke beranda</span>
    </a>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        @foreach($featured as $service)
            @php
                $city = $service->arrival_city ?: $service->departure_city ?: 'travel';
                $query = urlencode($city . ' travel landscape');
                $img = "https://source.unsplash.com/800x600/?{$query}";
            @endphp
            <div class="rounded-xl overflow-hidden shadow-lg bg-white">
                <img src="{{ $img }}" alt="{{ $city }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">{{ $service->departure_city }} → {{ $service->arrival_city }}</h3>
                    <div class="text-sm text-gray-500 mt-1">{{ $service->airline_name ?? 'Jathayu Airlines' }}</div>
                    <div class="flex items-center justify-between mt-4">
                        <div class="text-primary font-bold">Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</div>
                        <a href="{{ route('bookings.index', ['from' => $service->departure_city, 'to' => $service->arrival_city]) }}" class="px-4 py-2 bg-primary text-white rounded">Cari Penerbangan</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="text-2xl font-semibold mb-4">Semua Destinasi</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
        @foreach($cities as $city)
            @php $query = urlencode($city . ' city skyline'); $img = "https://source.unsplash.com/360x240/?{$query}"; @endphp
            <a href="{{ route('bookings.index', ['to' => $city]) }}" class="group block rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition">
                <div class="w-full h-28 bg-gray-100 overflow-hidden">
                    <img src="{{ $img }}" alt="{{ $city }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform">
                </div>
                <div class="p-2 text-center text-sm bg-white">
                    <div class="font-medium">{{ $city }}</div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
