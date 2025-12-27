@extends('layouts.app')

@section('title', $blog->title ?? 'Artikel')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">{{ $blog->title }}</h1>
    <p class="text-sm text-gray-500 mb-6">Oleh {{ $blog->author ?? 'Admin' }} • {{ $blog->created_at->format('d M Y') }}</p>
    <div class="prose max-w-none">
        {!! $blog->content !!}
    </div>
</div>
@endsection
