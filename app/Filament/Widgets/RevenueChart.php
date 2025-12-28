<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RevenueChart extends Widget
{
    protected string $view = 'filament.widgets.revenue-chart';

    protected ?string $heading = 'Revenue';

    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        $labels = [];
        $series = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->format('M d');
            $labels[] = $day;
            $series[] = (float) DB::table('bookings')->whereDate('created_at', Carbon::today()->subDays($i))->sum('total_price');
        }

        $total = array_sum($series);

        return view($this->view, compact('labels', 'series', 'total'));
    }
}
