@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container mx-auto py-8 max-w-2xl px-4">
    <h1 class="text-2xl font-semibold mb-6">Pembayaran Booking</h1>

    <div class="bg-white p-6 rounded shadow-sm">
        <div class="mb-4">
            <div class="text-sm text-gray-600">Kode Booking</div>
            <div class="text-lg font-medium">{{ $booking->booking_code }}</div>
        </div>
        <div class="mb-4">
            <div class="text-sm text-gray-600">Total yang harus dibayar</div>
            <div class="text-xl font-semibold">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</div>
        </div>

        <div>
            <button id="pay-button" class="px-4 py-2 bg-indigo-600 text-white rounded">Bayar via Midtrans (Sandbox)</button>
        </div>
    </div>

</div>

{{-- Include Midtrans Snap JS (sandbox) --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
document.getElementById('pay-button').addEventListener('click', function () {
    fetch("{{ route('payments.token', $booking) }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(r => r.json())
    .then(data => {
        if (data.token) {
            snap.pay(data.token, {
                onSuccess: function(result){
                    // Notify server to mark booking as paid (sandbox flow)
                    fetch("{{ route('payments.complete', $booking) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({result: result})
                    }).then(r => r.json()).then(j => {
                        if (j.success) {
                            alert('Pembayaran sukses (sandbox).');
                            window.location.href = '{{ route('bookings.show', $booking) }}?paid=1';
                        } else {
                            alert('Pembayaran sukses tapi gagal menandai pembayaran di server.');
                            window.location.href = '{{ route('bookings.show', $booking) }}';
                        }
                    }).catch(err => {
                        console.error(err);
                        alert('Pembayaran sukses tapi gagal menghubungi server.');
                        window.location.href = '{{ route('bookings.show', $booking) }}';
                    });
                },
                onPending: function(result){
                    alert('Pembayaran pending (sandbox).');
                    window.location.href = '{{ route('bookings.show', $booking) }}';
                },
                onError: function(result){
                    alert('Terjadi error saat pembayaran.');
                }
            });
        } else {
            alert('Gagal membuat token pembayaran.');
            console.error(data);
        }
    }).catch(err => { console.error(err); alert('Gagal membuat token pembayaran.'); });
});
</script>

@endsection
