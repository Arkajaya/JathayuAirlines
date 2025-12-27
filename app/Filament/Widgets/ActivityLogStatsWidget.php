<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\ActivityLog;
use Throwable;

class ActivityLogStatsWidget extends Widget
{
    protected string $view = 'filament.widgets.activity-log-stats-widget';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function getData(): array
    {
        $total = ActivityLog::count();
        $today = ActivityLog::whereDate('created_at', now()->toDateString())->count();
        $uniqueUsers = ActivityLog::distinct('user_id')->count('user_id');
        $errors = ActivityLog::where('action', 'like', '%error%')->count();

        return compact('total', 'today', 'uniqueUsers', 'errors');
    }
}
