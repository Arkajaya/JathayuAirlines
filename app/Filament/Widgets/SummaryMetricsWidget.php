<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Filament\Support\Icons\Heroicon;

class SummaryMetricsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Summary Metrics';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    protected function getCards(): array
    {
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
            } catch (\Throwable $e) {
                // ignore
            }
        }

        $netRevenue = $bookingQuery->sum('total_price') ?? 0;
        $totalProducts = $serviceQuery->count();
        $totalTransactions = $bookingQuery->count();

        $series = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->toDateString();
            $series[] = DB::table('bookings')->whereDate('created_at', $day)->sum('total_price') ?: 0;
        }

        return [
            \Filament\Widgets\StatsOverviewWidget\Stat::make('Net Revenue', 'Rp ' . number_format($netRevenue, 0, ',', '.'))
                ->chart($series)
                ->chartColor('emerald')
                ->icon(Heroicon::OutlinedCurrencyDollar)
                ->description('Last 7 days')
                ->descriptionIcon(Heroicon::ArrowTrendingUp)
                ->descriptionColor('emerald'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Total Products', $totalProducts)
                ->chart($series)
                ->chartColor('indigo')
                ->icon(Heroicon::OutlinedSquares2x2)
                ->description('Catalog')
                ->descriptionIcon(Heroicon::Squares2x2)
                ->descriptionColor('indigo'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Total Transactions', $totalTransactions)
                ->chart($series)
                ->chartColor('blue')
                ->icon(Heroicon::ArrowPath)
                ->description('Last 7 days')
                ->descriptionIcon(Heroicon::ArrowTrendingUp)
                ->descriptionColor('blue'),
        ];
    }
}
