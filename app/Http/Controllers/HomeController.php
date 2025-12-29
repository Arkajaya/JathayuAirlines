<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        // Prefer upcoming services, but include services without a departure_time
        // so admin-created entries aren't hidden. Increase limit to show more.
        $flights = Service::where('is_active', true)
            ->where(function($q) {
                $q->where('departure_time', '>', now())
                  ->orWhereNull('departure_time');
            })
            ->orderBy('departure_time', 'asc')
            ->take(8)
            ->get();

        $blogs = Blog::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Provide distinct city lists for the search form (from/to)
        // Use all active services for city lists (so search options include admin entries)
        $citiesFrom = Service::where('is_active', true)
            ->distinct()
            ->orderBy('departure_city')
            ->pluck('departure_city');

        $citiesTo = Service::where('is_active', true)
            ->distinct()
            ->orderBy('arrival_city')
            ->pluck('arrival_city');

        return view('home', compact('flights', 'blogs', 'citiesFrom', 'citiesTo'));
    }

    /**
     * Destinations gallery page — attractive cards with Unsplash images.
     */
    public function destinations()
    {
        // gather unique cities from active services
        $from = Service::where('is_active', true)->pluck('departure_city');
        $to = Service::where('is_active', true)->pluck('arrival_city');
        $cities = $from->merge($to)->filter()->unique()->values();

        // featured services (popular or latest)
        $featured = Service::where('is_active', true)
            ->orderByDesc('booked_seats')
            ->orderBy('departure_time', 'asc')
            ->take(12)
            ->get();

        return view('destinations', [
            'cities' => $cities,
            'featured' => $featured,
        ]);
    }
}