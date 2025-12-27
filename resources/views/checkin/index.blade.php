@extends('layouts.app')

@section('title', 'Check-in Online')

@section('content')
<div class="container mx-auto py-8 max-w-2xl px-4">
	<h1 class="text-2xl font-semibold mb-6">Check-in Online</h1>

	@if(session('error'))
		<div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-800">{{ session('error') }}</div>
	@endif
	@if(session('success'))
		<div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800">{{ session('success') }}</div>
	@endif

	<div class="bg-white shadow-sm rounded p-6">
		<p class="text-sm text-gray-700 mb-4">Masukkan kode booking Anda untuk mulai check-in. Anda akan melihat ringkasan booking dan dapat memilih penumpang untuk check-in.</p>

		<form action="{{ route('checkin.process') }}" method="POST" class="flex gap-3" role="search" aria-label="Cari booking untuk check-in">
			@csrf
			<input type="text" name="booking_code" placeholder="Kode Booking (mis. JA...)" required autofocus value="{{ old('booking_code') }}" class="flex-1 border rounded px-3 py-2" aria-label="Kode Booking">
			<button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Cari</button>
		</form>

		@error('booking_code')
			<p class="text-sm text-red-600 mt-3">{{ $message }}</p>
		@enderror
	</div>
</div>
@endsection
