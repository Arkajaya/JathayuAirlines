@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Pemesanan Saya</h1>
        <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:underline">Kembali ke beranda</a>
    </div>
    @foreach($bookings as $b)
        <div class="mb-3 border p-4 rounded">
            <p>{{ $b->booking_code }} - {{ $b->status }}</p>
            <a href="{{ route('bookings.show', $b) }}" class="text-primary">Lihat detail</a>
        </div>
    @endforeach
</div>
@endsection
