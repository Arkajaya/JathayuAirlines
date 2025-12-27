@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Pemesanan Saya</h1>
    @foreach($bookings as $b)
        <div class="mb-3 border p-4 rounded">
            <p>{{ $b->booking_code }} - {{ $b->status }}</p>
            <a href="{{ route('bookings.show', $b) }}" class="text-primary">Lihat detail</a>
        </div>
    @endforeach
</div>
@endsection
