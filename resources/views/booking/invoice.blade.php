<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $booking->booking_code }}</title>
    <style>
        body { font-family: Arial, sans-serif; color:#111; }
        .header { display:flex; justify-content:space-between; align-items:center; }
        .details { margin-top:20px; }
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        td, th { padding:8px; border:1px solid #ddd; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Invoice</h2>
        <div>{{ now()->format('d M Y') }}</div>
    </div>

    <div class="details">
        <strong>Kode Booking:</strong> {{ $booking->booking_code }}<br>
        <strong>Nama Pengguna:</strong> {{ $booking->user->name ?? '-' }}<br>
        <strong>Layanan:</strong> {{ $booking->service->departure_city ?? '-' }} → {{ $booking->service->arrival_city ?? '-' }}<br>
        <strong>Kelas:</strong> {{ $booking->travel_class ?? ($booking->service->class ?? '-') }}<br>
        <strong>Kursi:</strong> {{ !empty($booking->seats) ? implode(', ', $booking->seats) : '-' }}<br>
    </div>

    <table>
        <thead>
            <tr><th>Deskripsi</th><th>Jumlah</th><th>Harga</th></tr>
        </thead>
        <tbody>
            <tr>
                <td>Harga tiket (x{{ $booking->passenger_count }})</td>
                <td>{{ $booking->passenger_count }}</td>
                <td>Rp {{ number_format($booking->total_price,0,',','.') }}</td>
            </tr>
        </tbody>
    </table>

    <p>Terima kasih telah melakukan pemesanan.</p>
</body>
</html>
