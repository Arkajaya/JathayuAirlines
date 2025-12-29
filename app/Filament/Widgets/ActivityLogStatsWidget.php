<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use App\Models\ActivityLog;
use Illuminate\Support\Carbon;
use Filament\Support\Icons\Heroicon;

class ActivityLogStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Activity Logs';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    protected function getCards(): array
    {
        $total = ActivityLog::count();
        $today = ActivityLog::whereDate('created_at', now()->toDateString())->count();
        $uniqueUsers = ActivityLog::distinct('user_id')->count('user_id');
        $errors = ActivityLog::where('action', 'like', '%error%')->count();

        $series = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->toDateString();
            $series[] = ActivityLog::whereDate('created_at', $day)->count();
        }

        return [
            \Filament\Widgets\StatsOverviewWidget\Stat::make('Total Logs', $total)
                ->chart($series)
                ->chartColor('slate')
                ->icon(Heroicon::OutlinedClipboardDocumentList)
                ->description('All events')
                ->descriptionIcon(Heroicon::ClipboardDocumentList)
                ->descriptionColor('slate'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Today', $today)
                ->chart($series)
                ->chartColor('blue')
                ->icon(Heroicon::OutlinedSun)
                ->description('Today')
                ->descriptionIcon(Heroicon::Sun)
                ->descriptionColor('blue'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Unique Users', $uniqueUsers)
                ->chart($series)
                ->chartColor('emerald')
                ->icon(Heroicon::OutlinedUserGroup)
                ->description('Active users')
                ->descriptionIcon(Heroicon::Users)
                ->descriptionColor('emerald'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Errors', $errors)
                ->chart($series)
                ->chartColor('rose')
                ->icon(Heroicon::OutlinedExclamationTriangle)
                ->description('Warnings')
                ->descriptionIcon(Heroicon::ExclamationTriangle)
                ->descriptionColor('rose'),
        ];
    }
}
