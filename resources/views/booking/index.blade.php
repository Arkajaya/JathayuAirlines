@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Reservasi Layanan</h2>
    <div class="row">
        @foreach($services as $service)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $service->name }}</h5>
                    <p class="card-text">
                        <strong>Jenis:</strong> {{ $service->type }} <br>
                        <strong>Jadwal:</strong> {{ $service->schedule }} <br>
                        <strong>Kapasitas:</strong> {{ $service->capacity }} <br>
                        <strong>Harga:</strong> Rp {{ number_format($service->price, 0, ',', '.') }}
                    </p>
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="{{ $service->capacity }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Pesan</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection