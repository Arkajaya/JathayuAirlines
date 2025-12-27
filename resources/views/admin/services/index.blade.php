@extends('layouts.app')

@section('title', 'Admin - Services')

@section('content')
<div class="container">
    <h1>Services</h1>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary mb-3">Tambah Service</a>
    <ul>
        @foreach($services as $service)
            <li>{{ $service->name }} - Rp {{ number_format($service->price,0,',','.') }}</li>
        @endforeach
    </ul>
</div>
@endsection
