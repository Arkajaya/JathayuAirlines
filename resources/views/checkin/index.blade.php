@extends('layouts.app')

@section('title', 'Check-in Online')

@section('content')
<div class="container mx-auto py-12 px-4">
	<div class="max-w-2xl mx-auto">
		<div class="bg-white rounded-md shadow-lg overflow-hidden">
			<div class="px-6 py-6 bg-gradient-to-br from-sky-600 via-sky-400 to-sky-200 text-white">
				<div class="flex items-center gap-4">
					<svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden>
						<path d="M2 12h20" stroke="rgba(255,255,255,0.6)" stroke-width="1.5" stroke-linecap="round"/>
						<path d="M6 4l8 4-2 4" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					<div>
						<h1 class="text-xl font-bold tracking-wide">Check-in Online</h1>
						<div class="text-sm opacity-90">Masukkan kode booking untuk memulai proses check-in</div>
					</div>
				</div>
			</div>

			<div class="p-6">
				@if(session('error'))
					<div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-800">{{ session('error') }}</div>
				@endif
				@if(session('success'))
					<div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800">{{ session('success') }}</div>
				@endif

				<p class="text-sm text-gray-600 mb-4">Masukkan kode booking Anda yang tertera di email atau SMS konfirmasi. Contoh format: <span class="font-mono">JA1234AB</span></p>

				<form action="{{ route('checkin.process') }}" method="POST" class="space-y-4" role="search" aria-label="Cari booking untuk check-in">
					@csrf
					<div class="relative">
						<input type="text" name="booking_code" placeholder="Masukkan kode booking" required autofocus value="{{ old('booking_code') }}" class="w-full border rounded-lg px-4 py-3 pr-32 focus:outline-none focus:ring-2 focus:ring-indigo-300" aria-label="Kode Booking">
						<button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-sky-400 hover:bg-sky-600 text-white px-4 py-2 rounded-lg">Cari</button>
					</div>

					@error('booking_code')
						<p class="text-sm text-red-600">{{ $message }}</p>
					@enderror
				</form>

				<div class="mt-6 grid grid-cols-2 gap-3 text-xs text-gray-500">
					<div class="flex items-start gap-2">
						<svg class="w-4 h-4 mt-0.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.79-4 4v4h8v-4c0-2.21-1.79-4-4-4z"></path></svg>
						<div>Siapkan identitas saat check-in.</div>
					</div>
					<div class="flex items-start gap-2">
						<svg class="w-4 h-4 mt-0.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v6a9 9 0 009 9h0a9 9 0 009-9V7"></path></svg>
						<div>Check-in tersedia 24 jam sebelum keberangkatan.</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
