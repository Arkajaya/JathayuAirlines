@extends('layouts.app')

@section('title', 'Edit Service')

@section('content')
<div class="container">
    <h1>Edit Service</h1>
    <form action="{{ route('admin.services.update', $service) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="block">Nama</label>
            <input type="text" name="name" value="{{ $service->name }}" class="border rounded p-2 w-full">
        </div>
        <div class="mb-3">
            <label class="block">Harga</label>
            <input type="number" name="price" value="{{ $service->price }}" class="border rounded p-2 w-full">
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
