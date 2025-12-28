<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Boarding Pass - {{ $booking->booking_code }}</title>
    <style>
        body{font-family: Arial, Helvetica, sans-serif; color:#111; background: #f7fafc; padding:18px;}
        .ticket{max-width:760px;margin:0 auto;background:#fff;border-radius:8px;overflow:hidden;border:1px solid #e6e9ee}
        .ticket-header{display:flex;justify-content:space-between;align-items:center;padding:18px 22px;background:linear-gradient(90deg,#2563eb,#06b6d4);color:#fff}
        .airline{font-weight:700;font-size:18px}
        .route{font-size:20px;font-weight:800}
        .ticket-body{display:flex;padding:18px 22px;gap:16px}
        .left{flex:2}
        .right{flex:1;background:#f3f6fb;padding:12px;border-radius:6px;display:flex;flex-direction:column;justify-content:space-between}
        .meta{color:#4b5563;margin-top:6px;font-size:13px}
        .section{margin-bottom:12px}
        .label{color:#6b7280;font-size:12px}
        .value{font-weight:700;font-size:16px}
        .barcode{height:60px;background:#111;margin-top:10px;border-radius:4px}
        .qr{width:100%;height:110px;background:#fff;border:1px solid #e6e9ee;display:flex;align-items:center;justify-content:center;border-radius:6px}
        .footer-note{padding:12px 22px;background:#fff;border-top:1px dashed #e6e9ee;color:#6b7280;font-size:12px}
        @media print{ .ticket{border:none;box-shadow:none} }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-header">
            <div>
                <div class="airline">{{ $booking->service->airline_name ?? 'Maskapai' }}</div>
                <div class="meta">Kode Booking: <strong>{{ $booking->booking_code }}</strong></div>
            </div>
            <div style="text-align:right">
                <div class="route">{{ $booking->service->departure_city ?? '-' }} → {{ $booking->service->arrival_city ?? '-' }}</div>
                <div class="meta">{{ optional($booking->service->departure_time)->format('d M Y') ?? '-' }}</div>
            </div>
        </div>

        <div class="ticket-body">
            <div class="left">
                <div class="section">
                    <div class="label">Penumpang</div>
                    <div class="value">{{ $booking->user->name ?? ($booking->passenger_details[0]['name'] ?? '-') }}</div>
                    <div class="meta">{{ $booking->user->email ?? '' }}</div>
                </div>

                <div class="section">
                    <div class="label">Rincian Penerbangan</div>
                    <div style="display:flex;gap:18px;margin-top:6px">
                        <div>
                            <div class="label">Flight</div>
                            <div class="value">{{ $booking->service->flight_number ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="label">Kelas</div>
                            <div class="value">{{ $booking->travel_class ?? ($booking->service->class ?? '-') }}</div>
                        </div>
                        <div>
                            <div class="label">Kursi</div>
                            <div class="value">{{ !empty($booking->seats) ? implode(', ', $booking->seats) : '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="label">Waktu & Gate</div>
                    <div style="display:flex;gap:18px;margin-top:6px">
                        <div>
                            <div class="label">Keberangkatan</div>
                            <div class="value">{{ optional($booking->service->departure_time)->format('d M Y H:i') ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="label">Boarding</div>
                            <div class="value">{{ optional($booking->service->departure_time)->subMinutes(30)->format('H:i') ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="label">Gate</div>
                            <div class="value">{{ $booking->service->gate ?? 'TBD' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="right">
                <div>
                    <div class="label">Boarding Pass</div>
                    <div style="margin-top:6px">
                        <div class="qr">QR / Logo</div>
                    </div>
                </div>

                <div>
                    <div class="label">Pencetakan</div>
                    <div class="meta">{{ now()->format('d M Y H:i') }}</div>
                </div>
            </div>
        </div>

        <div class="footer-note">Harap hadir minimal 30 menit sebelum keberangkatan. Siapkan identitas yang sesuai dengan data penumpang.</div>
    </div>
</body>
</html>