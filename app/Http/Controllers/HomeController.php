<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $flights = Service::where('is_active', true)
            ->where('departure_time', '>', now())
            ->orderBy('departure_time', 'asc')
            ->take(4)
            ->get();

        $blogs = Blog::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('home', compact('flights', 'blogs'));
    }
}