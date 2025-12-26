@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Check-in Online</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('checkin.check') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="booking_code" class="form-label">Kode Booking</label>
                            <input type="text" class="form-control" id="booking_code" name="booking_code" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Check-in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection