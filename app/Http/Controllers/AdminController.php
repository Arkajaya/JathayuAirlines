<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cancellation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $now = now();
        $today = $now->toDateString();
        $todayBookings = Booking::whereDate('created_at', $today)->count();
        $pendingCancellations = Cancellation::where('status', 'pending')->count();
        // Use payment_status = 'paid' to compute realized revenue
        $monthlyRevenue = Booking::whereMonth('created_at', $now->month)
            ->where('payment_status', 'paid')
            ->sum('total_price');

        // Recent bookings for the table
        $recentBookings = Booking::latest()->take(10)->get();

        // Average occupancy across services (use Service accessor)
        $services = \App\Models\Service::where('capacity', '>', 0)->get();
        $occupancies = $services->map(fn($s) => $s->occupancy_rate ?? 0)->toArray();
        $averageOccupancy = count($occupancies) ? array_sum($occupancies) / count($occupancies) : 0;

        // Booking stats for last 30 days
        $dates = collect();
        $labels = [];
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $d = $now->copy()->subDays($i);
            $date = $d->format('Y-m-d');
            $labels[] = $d->format('d M');
            $data[] = Booking::whereDate('created_at', $date)->count();
        }
        $bookingStats = ['labels' => $labels, 'data' => $data];

        // Class distribution (if service has 'class' attribute)
        $classDistribution = [
            'labels' => [],
            'data' => [],
        ];
        $classCounts = Booking::with('service')
            ->whereMonth('created_at', $now->month)
            ->get()
            ->groupBy(function ($b) {
                return $b->service->class ?? 'Unknown';
            })
            ->map(fn($g) => $g->count());

        foreach ($classCounts as $class => $count) {
            $classDistribution['labels'][] = $class;
            $classDistribution['data'][] = $count;
        }

        return view('admin.dashboard', compact(
            'todayBookings',
            'pendingCancellations',
            'monthlyRevenue',
            'averageOccupancy',
            'recentBookings',
            'bookingStats',
            'classDistribution'
        ));
    }
}