<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Throwable;

class CancellationStatsWidget extends Widget
{
    protected string $view = 'filament.widgets.cancellation-stats-widget';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function getData(): array
    {
        $total = DB::table('cancellations')->count();
        $pending = DB::table('cancellations')->where('status', 'pending')->count();
        $approved = DB::table('cancellations')->where('status', 'approved')->count();
        $rejected = DB::table('cancellations')->where('status', 'rejected')->count();

        return [
            'total' => $total,
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
        ];
    }
}
