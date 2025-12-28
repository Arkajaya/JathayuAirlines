<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Filament\Support\Icons\Heroicon;

class ServiceStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Services';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    protected function getCards(): array
    {
        $total = DB::table('services')->count();
        $active = DB::table('services')->where('is_active', true)->count();
        $recent = DB::table('services')->whereDate('created_at', '>=', now()->subDays(7))->count();
        $popular = DB::table('services')
            ->leftJoin('bookings', 'services.id', '=', 'bookings.service_id')
            ->select('services.id', DB::raw('count(bookings.id) as bookings_count'))
            ->groupBy('services.id')
            ->orderByDesc('bookings_count')
            ->limit(1)
            ->first();

        $series = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->toDateString();
            $series[] = DB::table('services')->whereDate('created_at', $day)->count();
        }

        return [
            \Filament\Widgets\StatsOverviewWidget\Stat::make('Total Services', $total)
                ->chart($series)
                ->chartColor('indigo')
                ->icon(Heroicon::OutlinedSquares2x2)
                ->description('Catalog')
                ->descriptionIcon(Heroicon::Squares2x2)
                ->descriptionColor('indigo'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Active', $active)
                ->chart($series)
                ->chartColor('emerald')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->description('Available')
                ->descriptionIcon(Heroicon::Check)
                ->descriptionColor('emerald'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('New (7d)', $recent)
                ->chart($series)
                ->chartColor('blue')
                ->icon(Heroicon::OutlinedPlusCircle)
                ->description('Added')
                ->descriptionIcon(Heroicon::Plus)
                ->descriptionColor('blue'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Most Booked ID', $popular?->id ?? '-')
                ->chart($series)
                ->chartColor('violet')
                ->icon(Heroicon::OutlinedStar)
                ->description('Popular')
                ->descriptionIcon(Heroicon::Star)
                ->descriptionColor('violet'),
        ];
    }
}

