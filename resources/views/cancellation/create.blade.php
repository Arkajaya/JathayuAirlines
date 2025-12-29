@extends('layouts.app')

@section('title', 'Ajukan Pembatalan')

@section('content')
<div class="container mx-auto py-10 px-4 lg:px-0 max-w-3xl">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Ajukan Pembatalan</h1>
        <a href="{{ route('bookings.show', $booking) }}" class="text-sm text-gray-600 hover:underline">Kembali ke detail booking</a>
    </div>

    @if(session('status'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-start gap-6">
            <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-cyan-50 rounded flex items-center justify-center">
                <i class="fas fa-receipt text-indigo-600 text-2xl"></i>
            </div>
            <div class="flex-1">
                <h2 class="text-lg font-medium mb-1">Rincian Booking</h2>
                <div class="text-sm text-gray-600">Kode: <span class="font-medium">{{ $booking->booking_code ?? '-' }}</span></div>
                <div class="text-sm text-gray-600">Rute: {{ $booking->service->departure_city ?? '-' }} → {{ $booking->service->arrival_city ?? '-' }}</div>
                <div class="text-sm text-gray-600">Tanggal: {{ optional($booking->created_at)->format('d M Y') ?? '-' }}</div>
                <div class="mt-2 text-lg font-semibold text-primary">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <form action="{{ route('cancellations.store', $booking) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf

        <p class="text-sm text-gray-600 mb-4">Sebelum mengajukan pembatalan, mohon baca <a href="#" class="text-indigo-600 underline">kebijakan pembatalan</a> kami. Pengajuan akan ditinjau oleh tim dan diproses sesuai ketentuan.</p>

        <div class="mb-4">
            <label for="reason" class="block text-sm font-medium text-gray-700">Alasan Pembatalan <span class="text-red-500">*</span></label>
            <textarea name="reason" id="reason" rows="5" required class="mt-1 block w-full border border-gray-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-200">{{ old('reason') }}</textarea>
            @error('reason') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="refund_method" class="block text-sm font-medium text-gray-700">Metode Pengembalian (opsional)</label>
            <select name="refund_method" id="refund_method" class="mt-1 block w-full border border-gray-200 rounded-lg p-2">
                <option value="">Pilih metode (jika ada)</option>
                <option value="balance" {{ old('refund_method')=='balance' ? 'selected' : '' }}>Kredit Akun</option>
                <option value="bank" {{ old('refund_method')=='bank' ? 'selected' : '' }}>Transfer Bank</option>
            </select>
            @error('refund_method') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 border rounded-md text-sm text-gray-700">Batal</a>
            <button type="submit" class="inline-block px-5 py-2 bg-gradient-to-r from-indigo-600 to-cyan-500 text-white rounded-md text-sm shadow">Kirim Pengajuan</button>
        </div>
    </form>

</div>
@endsection
