<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Filament\Support\Icons\Heroicon;

class PaymentOverviewWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Payments';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    protected function getCards(): array
    {
        $totalRevenue = DB::table('bookings')->where('payment_status', 'paid')->sum('total_price');
        $todayRevenue = DB::table('bookings')->where('payment_status', 'paid')->whereDate('created_at', now())->sum('total_price');
        $paidCount = DB::table('bookings')->where('payment_status', 'paid')->count();
        $pending = DB::table('bookings')->where('payment_status', 'pending')->count();
        $refunded = DB::table('bookings')->where('payment_status', 'refunded')->count();

        // revenue series (7 days)
        $series = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->toDateString();
            $series[] = DB::table('bookings')->where('payment_status', 'paid')->whereDate('created_at', $day)->sum('total_price') ?: 0;
        }

        return [
            \Filament\Widgets\StatsOverviewWidget\Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->chart($series)
                ->chartColor('emerald')
                ->icon(Heroicon::OutlinedCurrencyDollar)
                ->description('Last 7 days')
                ->descriptionIcon(Heroicon::ArrowTrendingUp)
                ->descriptionColor('emerald'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make("Today's Revenue", 'Rp ' . number_format($todayRevenue, 0, ',', '.'))
                ->chart($series)
                ->chartColor('teal')
                ->icon(Heroicon::OutlinedSparkles)
                ->description('Today')
                ->descriptionIcon(Heroicon::Sun)
                ->descriptionColor('teal'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Transactions', sprintf('%d paid | %d refunded', $paidCount, $refunded))
                ->chart($series)
                ->chartColor('blue')
                ->icon(Heroicon::OutlinedReceiptPercent)
                ->description('Payments')
                ->descriptionIcon(Heroicon::CreditCard)
                ->descriptionColor('blue'),
        ];
    }
}
