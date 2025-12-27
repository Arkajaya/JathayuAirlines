<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Throwable;

class ServiceStatsWidget extends Widget
{
    protected string $view = 'filament.widgets.service-stats-widget';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function getData(): array
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

        return [
            'total' => $total,
            'active' => $active,
            'recent' => $recent,
            'popular' => $popular?->id ?? null,
        ];
    }
}

