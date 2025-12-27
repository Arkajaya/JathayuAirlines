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
        // increment views once per session to avoid inflated counts
        try {
            $key = 'viewed_blog_'.$blog->id;
            if (! session()->has($key)) {
                $blog->increment('views');
                session()->put($key, true);
            }
        } catch (\Throwable $e) {
            // swallow errors to avoid breaking the user view
            logger()->warning('Failed to increment blog views: '.$e->getMessage());
        }

        return view('blog.show', compact('blog'));
    }
}