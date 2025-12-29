<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use App\Models\User;
use Illuminate\Support\Carbon;
use Filament\Support\Icons\Heroicon;

class UserStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Users';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    protected function getCards(): array
    {
        $total = User::count();
        $admins = User::whereHas('roles', fn($q) => $q->where('name', 'Admin'))->count();
        $staff = User::whereHas('roles', fn($q) => $q->where('name', 'Staff'))->count();
        $recent = User::where('created_at', '>=', now()->subDays(7))->count();

        $series = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $label = $day->format('Y-m-d');
            $series[$label] = User::whereDate('created_at', $day->toDateString())->count();
        }

        return [
            \Filament\Widgets\StatsOverviewWidget\Stat::make('Total Users', $total)
                ->chart($series)
                ->chartColor('indigo')
                ->icon(Heroicon::OutlinedUsers)
                ->description('All users')
                ->descriptionIcon(Heroicon::User)
                ->descriptionColor('indigo'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Admins', $admins)
                ->chart($series)
                ->chartColor('slate')
                ->icon(Heroicon::OutlinedUserGroup)
                ->description('Admins')
                ->descriptionIcon(Heroicon::UserGroup)
                ->descriptionColor('slate'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Staff', $staff)
                ->chart($series)
                ->chartColor('amber')
                ->icon(Heroicon::OutlinedUserCircle)
                ->description('Staff')
                ->descriptionIcon(Heroicon::UserPlus)
                ->descriptionColor('amber'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('New (7d)', $recent)
                ->chart($series)
                ->chartColor('emerald')
                ->icon(Heroicon::OutlinedArrowTrendingUp)
                ->description('New users')
                ->descriptionIcon(Heroicon::ArrowTrendingUp)
                ->descriptionColor('emerald'),
        ];
    }
}
