<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Monthly revenue for last 12 months
        $now = Carbon::now();
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $m = $now->copy()->subMonths($i);
            $months[] = $m->format('Y-m');
        }

        $driver = config('database.connections.' . config('database.default') . '.driver', 'mysql');

        if ($driver === 'pgsql') {
            $monthExpr = "to_char(created_at, 'YYYY-MM')";
        } else {
            // fallback to MySQL-style
            $monthExpr = "DATE_FORMAT(created_at, '%Y-%m')";
        }

        // Include all bookings for revenue aggregates (paid or not) to ensure chart shows values when present.
        $revenueRows = Booking::selectRaw("{$monthExpr} as month, SUM(total_price) as revenue")
            ->where('created_at', '>=', $now->copy()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        $monthlyRevenue = array_map(function ($m) use ($revenueRows) {
            return isset($revenueRows[$m]) ? (float) $revenueRows[$m] : 0.0;
        }, $months);

        // Bookings in last 30 days (per day)
        $days = [];
        $labels30 = [];
        for ($d = 29; $d >= 0; $d--) {
            $day = $now->copy()->subDays($d);
            $labels30[] = $day->format('Y-m-d');
        }

        // Use DATE(created_at) which works on MySQL/Postgres; if driver is pgsql, prefer to_char for explicit format
        if ($driver === 'pgsql') {
            $dayExpr = "to_char(created_at, 'YYYY-MM-DD')";
        } else {
            $dayExpr = "DATE(created_at)";
        }

        $bookingsRows = Booking::selectRaw("{$dayExpr} as day, COUNT(*) as cnt")
            ->where('created_at', '>=', $now->copy()->subDays(29)->startOfDay())
            ->groupBy('day')
            ->pluck('cnt', 'day')
            ->toArray();

        $bookings30 = array_map(function ($d) use ($bookingsRows) {
            return isset($bookingsRows[$d]) ? (int) $bookingsRows[$d] : 0;
        }, $labels30);

        // Class distribution (by service.class)
        // Class distribution: treat null/empty classes as 'Unknown'
        $classRows = Booking::leftJoin('services', 'bookings.service_id', '=', 'services.id')
            ->selectRaw("COALESCE(NULLIF(services.class, ''), 'Unknown') as svc_class, COUNT(bookings.id) as cnt")
            ->groupBy('svc_class')
            ->pluck('cnt', 'svc_class')
            ->toArray();

        $classLabels = array_keys($classRows);
        $classData = array_values($classRows);

        // Average occupancy across services (percentage)
        $services = Service::where('capacity', '>', 0)->get();
        $occupancies = $services->map(function ($s) {
            return $s->occupancy_rate; // attribute from model
        })->toArray();

        $averageOccupancy = count($occupancies) ? array_sum($occupancies) / count($occupancies) : 0;

        return view('infographics', [
            'months' => array_map(function ($m) {
                return Carbon::createFromFormat('Y-m', $m)->format('M Y');
            }, $months),
            'monthlyRevenue' => $monthlyRevenue,
            'labels30' => $labels30,
            'bookings30' => $bookings30,
            'classLabels' => $classLabels,
            'classData' => $classData,
            'averageOccupancy' => round($averageOccupancy, 2),
        ]);
    }
}
