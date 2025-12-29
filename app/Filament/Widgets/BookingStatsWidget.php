<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Filament\Support\Icons\Heroicon;

class BookingStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Booking Statistics';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasAnyRole(['Admin', 'Staff']);
    }

    protected function getCards(): array
    {
        $total = DB::table('bookings')->count();
        $pending = DB::table('bookings')->where('status', 'pending')->count();
        $checkedIn = DB::table('bookings')->where('status', 'checked_in')->count();

        // build 7-day series for bookings
        $series = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->toDateString();
            $series[] = DB::table('bookings')->whereDate('created_at', $day)->count();
        }

        return [
            \Filament\Widgets\StatsOverviewWidget\Stat::make('Total Bookings', $total)
                ->chart($series)
                ->chartColor('blue')
                ->icon(Heroicon::OutlinedSquares2x2)
                ->description('Total')
                ->descriptionIcon(Heroicon::ShoppingCart)
                ->descriptionColor('blue'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Pending Payment', $pending)
                ->chart($series)
                ->chartColor('amber')
                ->icon(Heroicon::OutlinedClock)
                ->description('Awaiting')
                ->descriptionIcon(Heroicon::Clock)
                ->descriptionColor('amber'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Checked In', $checkedIn)
                ->chart($series)
                ->chartColor('emerald')
                ->icon(Heroicon::OutlinedCheckBadge)
                ->description('Arrivals')
                ->descriptionIcon(Heroicon::ArrowDown)
                ->descriptionColor('emerald'),
        ];
    }
}
