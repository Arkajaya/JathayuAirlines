<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Throwable;

class SummaryMetricsWidget extends Widget
{
    protected string $view = 'filament.widgets.summary-metrics-widget';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function getData(): array
    {
        // Allow optional date range filtering via query params: dashboard_start, dashboard_end
        $start = request()->query('dashboard_start');
        $end = request()->query('dashboard_end');

        $bookingQuery = DB::table('bookings');
        $serviceQuery = DB::table('services');

        if ($start && $end) {
            try {
                $startDt = Carbon::parse($start)->startOfDay();
                $endDt = Carbon::parse($end)->endOfDay();
                $bookingQuery->whereBetween('created_at', [$startDt, $endDt]);
                $serviceQuery->whereBetween('created_at', [$startDt, $endDt]);
            } catch (Throwable $e) {
                // ignore parse errors and fallback to unfiltered
            }
        }

        $netRevenue = $bookingQuery->sum('total_price') ?? 0;
        $totalProducts = $serviceQuery->count();
        $totalTransactions = $bookingQuery->count();

        return [
            'netRevenue' => number_format($netRevenue, 2),
            'totalProducts' => number_format($totalProducts),
            'totalTransactions' => number_format($totalTransactions),
        ];
    }
}
