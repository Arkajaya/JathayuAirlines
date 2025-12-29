@extends('layouts.app')

@section('title', 'Tambah Service')

@section('content')
<div class="container">
    <h1>Tambah Service</h1>
    <form action="{{ route('admin.services.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="block">Nama</label>
            <input type="text" name="name" class="border rounded p-2 w-full">
        </div>
        <div class="mb-3">
            <label class="block">Harga</label>
            <input type="number" name="price" class="border rounded p-2 w-full">
        </div>
        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
