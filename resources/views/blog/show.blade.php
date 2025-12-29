@extends('layouts.app')

@section('title', $blog->title ?? 'Artikel')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-4xl mx-auto py-8 pb-24">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-primary mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke beranda
        </a>

        <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $blog->title }}</h1>
        <p class="text-sm text-gray-500 mb-6">Oleh {{ $blog->author ?? 'Admin' }} • {{ $blog->created_at->format('d M Y') }}</p>

        @if($blog->featured_image)
            <img src="{{ asset('storage/'.$blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full max-h-96 object-cover rounded mb-8">
        @endif

        <div class="prose max-w-none text-base leading-relaxed">
            {!! $blog->content !!}
        </div>
    </div>
</div>
@endsection
