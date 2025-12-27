<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use Throwable;

class UserStatsWidget extends Widget
{
    protected string $view = 'filament.widgets.user-stats-widget';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function getData(): array
    {
        $total = User::count();
        $admins = User::whereHas('roles', fn($q) => $q->where('name', 'Admin'))->count();
        $staff = User::whereHas('roles', fn($q) => $q->where('name', 'Staff'))->count();
        $recent = User::where('created_at', '>=', now()->subDays(7))->count();

        return compact('total', 'admins', 'staff', 'recent');
    }
}
