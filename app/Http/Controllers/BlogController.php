<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        // Show only published blogs and paginate for better UX
        $blogs = Blog::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('blog.index', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        return view('blog.show', compact('blog'));
    }
}