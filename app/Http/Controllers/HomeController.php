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

        // Provide distinct city lists for the search form (from/to)
        $citiesFrom = Service::where('is_active', true)
            ->where('departure_time', '>', now())
            ->distinct()
            ->orderBy('departure_city')
            ->pluck('departure_city');

        $citiesTo = Service::where('is_active', true)
            ->where('departure_time', '>', now())
            ->distinct()
            ->orderBy('arrival_city')
            ->pluck('arrival_city');

        return view('home', compact('flights', 'blogs', 'citiesFrom', 'citiesTo'));
    }
}