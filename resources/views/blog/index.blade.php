@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Blog</h2>
    <div class="row">
        @foreach($blogs as $blog)
        <div class="col-md-4 mb-4">
            <div class="card">
                @if($blog->image)
                <img src="{{ asset('storage/'.$blog->image) }}" class="card-img-top" alt="{{ $blog->title }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $blog->title }}</h5>
                    <p class="card-text">{{ Str::limit($blog->content, 100) }}</p>
                    <a href="{{ route('blog.show', $blog->id) }}" class="btn btn-primary">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection