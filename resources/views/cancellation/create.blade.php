@extends('layouts.app')

@section('title', 'Ajukan Pembatalan')

@section('content')
<div class="container mx-auto py-8 px-4 lg:px-0 max-w-3xl">
    <h1 class="text-2xl font-semibold mb-6">Ajukan Pembatalan</h1>

    @if(session('status'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white shadow-sm rounded p-4 mb-6">
        <h2 class="text-lg font-medium mb-2">Rincian Booking</h2>
        <dl class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm text-gray-700">
            <div>
                <dt class="font-semibold">Kode Booking</dt>
                <dd>{{ $booking->booking_code ?? '-' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Layanan</dt>
                <dd>{{ $booking->service->name ?? '-' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Tanggal</dt>
                <dd>{{ optional($booking->created_at)->format('d M Y') ?? '-' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Jumlah Penumpang</dt>
                <dd>{{ $booking->passenger_count ?? '-' }}</dd>
            </div>
            <div class="col-span-2">
                <dt class="font-semibold">Total</dt>
                <dd class="text-lg font-semibold">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</dd>
            </div>
        </dl>
    </div>

    <form action="{{ route('cancellations.store', $booking) }}" method="POST" class="bg-white shadow-sm rounded p-6">
        @csrf

        <p class="text-sm text-gray-600 mb-4">Sebelum mengajukan pembatalan, mohon baca kebijakan pembatalan kami. Pengajuan akan ditinjau oleh tim dan diproses sesuai ketentuan.</p>

        <div class="mb-4">
            <label for="reason" class="block text-sm font-medium text-gray-700">Alasan Pembatalan <span class="text-red-500">*</span></label>
            <textarea name="reason" id="reason" rows="5" required class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('reason') }}</textarea>
            @error('reason') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="refund_method" class="block text-sm font-medium text-gray-700">Metode Pengembalian (opsional)</label>
            <select name="refund_method" id="refund_method" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                <option value="">Pilih metode (jika ada)</option>
                <option value="balance" {{ old('refund_method')=='balance' ? 'selected' : '' }}>Kredit Akun</option>
                <option value="bank" {{ old('refund_method')=='bank' ? 'selected' : '' }}>Transfer Bank</option>
            </select>
            @error('refund_method') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('bookings.show', $booking) }}" class="text-sm text-gray-600 hover:underline">Kembali ke detail booking</a>
            <div class="space-x-2">
                <a href="{{ url()->previous() }}" class="inline-block px-4 py-2 border rounded text-sm text-gray-700">Batal</a>
                <button type="submit" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded text-sm">Kirim Pengajuan</button>
            </div>
        </div>
    </form>

</div>
@endsection
