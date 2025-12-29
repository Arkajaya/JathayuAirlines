<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Filament\Support\Icons\Heroicon;

class CancellationStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Cancellations';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    protected function getCards(): array
    {
        $total = DB::table('cancellations')->count();
        $pending = DB::table('cancellations')->where('status', 'pending')->count();
        $approved = DB::table('cancellations')->where('status', 'approved')->count();
        $rejected = DB::table('cancellations')->where('status', 'rejected')->count();

        $series = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->toDateString();
            $series[] = DB::table('cancellations')->whereDate('created_at', $day)->count();
        }

        return [
            \Filament\Widgets\StatsOverviewWidget\Stat::make('Total Cancellations', $total)->chart($series)->chartColor('rose')->icon(Heroicon::OutlinedXCircle),
            \Filament\Widgets\StatsOverviewWidget\Stat::make('Pending', $pending)->chart($series)->chartColor('amber')->icon(Heroicon::OutlinedClock),
            \Filament\Widgets\StatsOverviewWidget\Stat::make('Approved', $approved)->chart($series)->chartColor('emerald')->icon(Heroicon::OutlinedCheck),
            \Filament\Widgets\StatsOverviewWidget\Stat::make('Rejected', $rejected)->chart($series)->chartColor('slate')->icon(Heroicon::OutlinedMinusCircle),
        ];
    }
}
