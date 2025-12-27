@extends('layouts.app')

@section('title', 'Artikel & Tips')

@section('content')
<div class="container mx-auto py-8 px-4 max-w-6xl">
    <h1 class="text-3xl font-bold mb-6">Artikel & Tips</h1>

    @if($blogs->isEmpty())
        <p class="text-sm text-gray-600">Belum ada artikel tersedia.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($blogs as $blog)
                <article class="bg-white rounded-lg shadow p-4">
                    @if($blog->image)
                        <img src="{{ asset('storage/'.$blog->image) }}" alt="{{ $blog->title }}" class="w-full h-40 object-cover rounded mb-4">
                    @endif
                    <h2 class="text-lg font-semibold mb-2">{{ $blog->title }}</h2>
                    <div class="text-xs text-gray-500 mb-3">{{ $blog->author ?? 'Admin' }} • {{ $blog->created_at->format('d M Y') }}</div>
                    <p class="text-sm text-gray-700 mb-4">{{ Str::limit(strip_tags($blog->content), 140) }}</p>
                    <a href="{{ route('blogs.show', $blog->slug) }}" class="text-primary font-medium">Baca Selengkapnya →</a>
                </article>
            @endforeach
        </div>

        <div class="mt-8">{{ $blogs->links() }}</div>
    @endif
</div>
@endsection