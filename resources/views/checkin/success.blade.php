@extends('layouts.app')

@section('title', 'Check-in Berhasil')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Check-in Berhasil</h1>
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800">{{ session('success') }}</div>
    @endif

    <p>Terima kasih, check-in untuk booking <strong>{{ $booking->booking_code }}</strong> telah berhasil.</p>
    <div class="mt-4">
        <a href="{{ route('bookings.show', $booking) }}" class="text-indigo-600 hover:underline">Kembali ke detail booking</a>
        <span class="mx-2">•</span>
        <a href="#" class="text-indigo-600 hover:underline">Download Boarding Pass (sementara tidak tersedia)</a>
    </div>
</div>
@endsection
