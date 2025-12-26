@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pengajuan Pembatalan</h2>
    <a href="{{ route('booking.index') }}" class="btn btn-primary mb-3">Ajukan Pembatalan</a>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kode Booking</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cancellations as $cancellation)
                <tr>
                    <td>{{ $cancellation->booking->booking_code }}</td>
                    <td>{{ $cancellation->reason }}</td>
                    <td>
                        @if($cancellation->status == 'pending')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($cancellation->status == 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>{{ $cancellation->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection